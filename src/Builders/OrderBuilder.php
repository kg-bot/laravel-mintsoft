<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace KgBot\Mintsoft\Builders;


use KgBot\Mintsoft\Models\Order;

class OrderBuilder extends Builder
{
    protected $entity = 'Order';
    protected $model  = Order::class;

    /**
     * @inheritDoc
     */
    public function get( $filters = [] )
    {
        $this->entity .= '/Search';

        return parent::get( $filters );
    }
}