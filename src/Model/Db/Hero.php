<?php

declare(strict_types=1);

namespace Take\Model\Db;

use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Hero extends AbstractModel
{
    /**
     * [factory description].
     *
     * @param CapsuleManager $db [description]
     *
     * @return [type] [description]
     */
    public function factory(CapsuleManager $db): QueryBuilder
    {
        return $db->table('heroes');
    }
}
