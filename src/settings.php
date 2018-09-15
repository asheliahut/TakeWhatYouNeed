<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'pdo' => [
            'driver'    => 'mysql',
            'host'      => \getenv('MYSQL_HOST') ?: 'mysql',
            'database'  => \getenv('MYSQL_DBNAME') ?: 'starwars',
            'username'  => \getenv('MYSQL_USER') ?: 'sithLord',
            'password'  => \getenv('MYSQL_PASS') ?: 'embraceTheDarkSide',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
