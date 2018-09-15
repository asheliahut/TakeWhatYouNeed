<?php

namespace Take\Resolver;

use Illuminate\Database\Query\Builder;

class HeroResolver {

    protected $value;
    protected $args;
    protected $heroTable;

    public static function artoo()
    {
        return [

            'id'              => '2001',
            'name'            => 'R2-D2',
            'friends'         => ['1000', '1002', '1003'],
            'appearsIn'       => [4, 5, 6],
            'primaryFunction' => 'Astromech',
        ];
    }

    private static function luke()
    {
        return [
            'id'         => '1000',
            'name'       => 'Luke Skywalker',
            'friends'    => ['1002', '1003', '2000', '2001'],
            'appearsIn'  => [4, 5, 6],
            'homePlanet' => 'Tatooine',
        ];
    }

    public function __construct($value, ?array $args, Builder $heroTable)
    {
        $this->value = $value;
        $this->args = $args;
        $this->heroTable = $heroTable;
    }

    public function query() {
        if(isset($this->args) && isset($this->args['episode'])) {
            return $this->queryEpisode($this->args['episode']);
        }
        return self::luke();
    }

    private function queryEpisode($episode) {
        if (5 === $episode) {
            // Luke is the hero of Episode V.
            return self::luke();
        }

        // Artoo is the hero otherwise.
        return self::artoo();
    }

}
