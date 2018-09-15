<?php

declare(strict_types=1);

namespace Take\Model\Db;

use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Human extends AbstractModel
{
    /**
     * Instantiates a new object for the given database table.
     *
     * @param CapsuleManager $db A Laravel Capsule Manager object.
     *
     * @return QueryBuilder
     */
    public function factory(CapsuleManager $db): QueryBuilder
    {
        return $db->table('humans');
    }
}
