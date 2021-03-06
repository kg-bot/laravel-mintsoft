<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace KgBot\Mintsoft\Builders;


use KgBot\Mintsoft\Models\Product;

class ProductBuilder extends Builder
{

    protected $entity = 'Product';
    protected $model  = Product::class;

    /**
     * @inheritDoc
     */
    public function get( $filters = [] )
    {
        $this->entity .= '/Search';

        return parent::get( $filters );
    }
}