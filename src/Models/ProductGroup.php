<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.02
 */

namespace KgBot\Models;


use KgBot\Utils\Model;

class ProductGroup extends Model
{
    public    $number;
    protected $entity     = 'product-groups';
    protected $primaryKey = 'number';
}