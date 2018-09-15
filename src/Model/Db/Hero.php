<?php
/**
 * Copyright (c) 2017-2018 McGraw-Hill Education <http://mheducation.com>.
 *
 * All rights reserved, unless this code has already been open-sourced elsewhere.
 */

declare(strict_types=1);

namespace Authoring\Model\Db;

use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Organizations extends AbstractModel
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
        return $db->table('organizations');
    }
}
