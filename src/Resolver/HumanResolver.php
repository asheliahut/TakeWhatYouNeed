<?php

namespace Take\Resolver;

use Illuminate\Database\Query\Builder;

class HumanResolver {

    protected $value;
    protected $args;
    protected $humanTable;

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

    public function __construct($value, ?array $args, Builder $humanTable)
    {
        $this->value = $value;
        $this->args = $args;
        $this->humanTable = $humanTable;
    }

    public function query() {
        if(isset($this->args) && isset($this->args['episode'])) {
            $episode = $this->args['episode'];
            return $this->queryEpisode($episode);
        }
        return null;
    }

    private function queryEpisode($episode) {
        // Query database here
        return $this->humanTable->where('episode', $episode)->get();
    }

    public function getFriends() {
        return [];
    }

}
