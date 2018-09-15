<?php
// DIC configuration
use \Illuminate\Database\Capsule\Manager as CapsuleManager;
use \Slim\Container;
use function Digia\GraphQL\buildSchema;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = static function (Container $c): CapsuleManager {
    $capsule = new CapsuleManager();
    $capsule->addConnection($c['settings']['pdo']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

// database
$container['db.hero'] = static function (Container $c) {
    $heroFactory = new Take\Model\Db\Hero();

    return $heroFactory->factory($c['db']);
};
$container['db.human'] = static function (Container $c) {
    $humanFactory = new Take\Model\Db\Human();

    return $humanFactory->factory($c['db']);
};
$container['db.droid'] = static function (Container $c) {
    $droidFactory = new Take\Model\Db\Droid();

    return $droidFactory->factory($c['db']);
};

$container['GraphQlQueries'] = static function (Container $c) {
    return [
        'Query' => \Digia\GraphQL\Test\Unit\Schema\Resolver\QueryResolver::class,
        'hero' => function ($value, $arguments) use ($c) {
            $heroResolver = new Take\Resolver\HeroResolver($value, $arguments, $c['db.hero']);
            return $heroResolver->query();
        },
        'human' => function ($value, $arguments) use ($c) {
            $humanResolver = new Take\Resolver\HumanResolver($value, $arguments, $c['db.human']);
            return $humanResolver->query();
        },
        'droid' => function ($value, $arguments) use ($c) {
            $droidResolver = new Take\Resolver\DroidResolver($value, $arguments, $c['db.droid']);
            return $droidResolver->query();
        },
    ];
};

$container['GraphQlHuman'] = static function (Container $c) {
    return [
        'friends' => function ($human) use ($c) {
            $humanResolver = new Take\Resolver\HumanResolver($human, null, $c['db.human']);

            return $humanResolver->getFriends();
        },
        'secretBackstory' => function () {
            throw new \Exception('secretBackstory is secret.');
        },
    ];
};

$container['GraphQlDroid'] = static function (Container $c) {
    return [
        'friends' => function ($droid) use ($c) {
            $droidResolver = new Take\Resolver\DroidResolver($droid, null, $c['db.droid']);

            return $droidResolver->getFriends();
        },
        'secretBackstory' => function () {
            throw new \Exception('secretBackstory is secret.');
        },
    ];
};

$container['GraphQlSchema'] = static function (Container $c) {
    $schemaDef = \file_get_contents(__DIR__ . '/Schema/starWars.graphqls');
    $executableSchema = buildSchema($schemaDef, [
        'Query' => $c['GraphQlQueries'],
        'Human' => $c['GraphQlHuman'],
        'Droid' => $c['GraphQlDroid'],
    ]);

    return $executableSchema;
};

$container['GraphQlService'] = static function (Container $c) {
    return new Take\GraphQl\GraphQLService($c['GraphQlSchema']);
};

$container['GraphQlController'] = static function (Container $c) {
    return new Take\Controller\GraphQlController($c['GraphQlService']);
};
