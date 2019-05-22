<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace KgBot\Mintsoft\Builders;

use KgBot\Mintsoft\Models\Warehouse;

class WarehouseBuilder extends Builder
{
    protected $entity = 'Warehouse';
    protected $model  = Warehouse::class;
}