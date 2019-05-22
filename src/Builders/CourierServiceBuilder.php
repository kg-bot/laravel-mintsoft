<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace KgBot\Mintsoft\Builders;

use KgBot\Mintsoft\Models\CourierService;

class CourierServiceBuilder extends Builder
{
    protected $entity = 'Courier/Services';
    protected $model  = CourierService::class;
}