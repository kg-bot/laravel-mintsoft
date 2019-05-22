<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.12
 */

namespace KgBot\Mintsoft;

use KgBot\Mintsoft\Builders\CourierServiceBuilder;
use KgBot\Mintsoft\Builders\OrderBuilder;
use KgBot\Mintsoft\Builders\ProductBuilder;
use KgBot\Mintsoft\Builders\WarehouseBuilder;
use KgBot\Mintsoft\Utils\Request;

class Mintsoft
{
    /**
     * @var $request Request
     */
    protected $request;

    /**
     * Rackbeat constructor.
     *
     * @param null  $token   API token
     * @param array $options Custom Guzzle options
     * @param array $headers Custom Guzzle headers
     */
    public function __construct( $username = null, $password = null, $options = [], $headers = [] )
    {
        $this->initRequest( $username, $password, $options, $headers );
    }

    /**
     * @param       $token
     * @param array $options
     * @param array $headers
     */
    private function initRequest( $username, $password, $options = [], $headers = [] )
    {
        $this->request = new Request( $username, $password, $options, $headers );
    }

    /**
     * @return \KgBot\Mintsoft\Builders\ProductBuilder
     */
    public function products()
    {
        return new ProductBuilder( $this->request );
    }

    /**
     * @return \KgBot\Mintsoft\Builders\OrderBuilder
     */
    public function orders()
    {
        return new OrderBuilder( $this->request );
    }

    /**
     * @return \KgBot\Mintsoft\Builders\WarehouseBuilder
     */
    public function warehouses()
    {
        return new WarehouseBuilder( $this->request );
    }

    /**
     * @return \KgBot\Mintsoft\Builders\CourierServiceBuilder
     */
    public function courier_services()
    {
        return new CourierServiceBuilder( $this->request );
    }
}