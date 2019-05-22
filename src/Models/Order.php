<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace KgBot\Mintsoft\Models;


use KgBot\Mintsoft\Utils\Model;

class Order extends Model
{
    protected $entity     = 'Order';
    protected $primaryKey = 'ID';

    public function addConnectAction( $data = [] )
    {

        $urlFilters = $this->parseFilters();

        return $this->request->handleWithExceptions( function () use ( $data, $urlFilters ) {

            $response =
                $this->request->client->put( "{$this->entity}/{$this->{$this->primaryKey}}/ConnectActions{$urlFilters}",
                    [
                        'json' => $data,
                    ] );

            $responseData = json_decode( (string) $response->getBody() );

            return $responseData;
        } );
    }
}
