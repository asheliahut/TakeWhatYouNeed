<?php

namespace Take\Resolver;

use Illuminate\Database\Query\Builder;

class DroidResolver {

    protected $value;
    protected $args;
    protected $droidTable;

    public function __construct($value, ?array $args, Builder $droidTable)
    {
        $this->value = $value;
        $this->args = $args;
        $this->droidTable = $droidTable;
    }

    public function query() {
        if(isset($this->args)) {
            foreach ($this->args as $key => $val) {
                $this->droidTable->where($key, $val);
            }

            return $this->droidTable->get();
        }

        return null;
    }

    public function getFriends() {
        return [];
    }

}
