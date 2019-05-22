<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 17.00
 */

namespace KgBot\Mintsoft\Builders;

use KgBot\Mintsoft\Utils\Filters;
use KgBot\Mintsoft\Utils\Model;
use KgBot\Mintsoft\Utils\Request;


class Builder
{
    use Filters;

    protected $entity;
    /** @var Model */
    protected $model;
    protected $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection|Model[]
     */
    public function get( $filters = [] )
    {
        $urlFilters = $this->parseFilters( $filters );

        return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

            $response     = $this->request->client->get( "{$this->entity}{$urlFilters}" );
            $responseData = json_decode( (string) $response->getBody() );
            $items        = $this->parseResponse( $responseData );
            $pages        = ( isset( $responseData->meta->paging ) ) ? $responseData->meta->paging->total : null;

            // todo implement paging

            return $items;
        } );
    }

    protected function parseResponse( $response )
    {
        $fetchedItems = collect( $response );
        $items        = collect( [] );

        foreach ( $fetchedItems as $index => $item ) {


            /** @var Model $model */
            $model = new $this->model( $this->request, $item );

            $items->push( $model );

        }

        return $items;
    }


    public function find( $id )
    {
        $urlFilters = $this->parseFilters();


        return $this->request->handleWithExceptions( function () use ( $id, $urlFilters ) {

            $response     = $this->request->client->get( "{$this->entity}/{$id}{$urlFilters}" );
            $responseData = json_decode( (string) $response->getBody() );


            return new $this->model( $this->request, $responseData );
        } );
    }

    public function create( $data )
    {

        $urlFilters = $this->parseFilters();

        return $this->request->handleWithExceptions( function () use ( $data, $urlFilters ) {

            $response = $this->request->client->put( "{$this->entity}{$urlFilters}", [
                'json' => $data,
            ] );

            $responseData = json_decode( (string) $response->getBody() );

            $responseData = ( is_array( $responseData ) ) ? $responseData[ 0 ] : $responseData;


            return new $this->model( $this->request, $responseData );
        } );
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity( $new_entity )
    {
        $this->entity = $new_entity;

        return $this->entity;
    }

    private function switchComparison( $comparison )
    {
        switch ( $comparison ) {
            case '=':
            case '==':
                $newComparison = '$eq:';
                break;
            case '!=':
                $newComparison = '$ne:';
                break;
            case '>':
                $newComparison = '$gt:';
                break;
            case '>=':
                $newComparison = '$gte:';
                break;
            case '<':
                $newComparison = '$lt:';
                break;
            case '<=':
                $newComparison = '$lte:';
                break;
            case 'like':
                $newComparison = '$like:';
                break;
            case 'in':
                $newComparison = '$in:';
                break;
            case '!in':
                $newComparison = '$nin:';
                break;
            default:
                $newComparison = "${$comparison}:";
                break;
        }

        return $newComparison;
    }
}