<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.53
 */

namespace KgBot\Mintsoft\Utils;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use KgBot\Mintsoft\Exceptions\MintsoftClientException;
use KgBot\Mintsoft\Exceptions\MintsoftRequestException;

class Request
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $client;
    /**
     * API Key
     *
     * @var string $api_key
     **/
    private $api_key;
    /**
     * Username
     *
     * @var string $username
     **/
    private $username;
    /**
     * Password
     *
     * @var string $password
     **/
    private $password;
    /**
     * @var array $options
     */
    private $options = [];

    /**
     * Request constructor.
     *
     * @param null  $token
     * @param array $options
     * @param array $headers
     */
    public function __construct( $username = null, $password = null, $options = [], $headers = [] )
    {
        $this->username = $username ?? config( 'mintsoft.username' );
        $this->password = $password ?? config( 'mintsoft.password' );

        $this->get_auth();

        $headers      = array_merge( $headers, [

            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ] );
        $options      = array_merge( $options, [

            'base_uri' => config( 'mintsoft.base_uri' ),
            'headers'  => $headers,
        ] );
        $this->client = new Client( $options );
    }

    private function get_auth()
    {
        $query = http_build_query( [

            'UserName' => $this->username,
            'Password' => $this->password,
        ] );

        $options = [
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        ];

        $ch = curl_init( config( 'mintsoft.base_uri' ) . 'Auth?' . $query );
        curl_setopt_array( $ch, $options );
        $response = curl_exec( $ch );
        curl_close( $ch );

        $this->api_key = trim( $response, '""' );
    }

    /**
     * @param $callback
     *
     * @return mixed
     * @throws \KgBot\Mintsoft\Exceptions\MintsoftClientException
     * @throws \KgBot\Mintsoft\Exceptions\MintsoftRequestException
     */
    public function handleWithExceptions( $callback )
    {
        try {
            return $callback();

        } catch ( ClientException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new MintsoftRequestException( $message, $code );

        } catch ( ServerException $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {

                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new MintsoftRequestException( $message, $code );

        } catch ( Exception $exception ) {

            $message = $exception->getMessage();
            $code    = $exception->getCode();

            throw new MintsoftClientException( $message, $code );
        }
    }

    public function getApiKey()
    {

        return $this->api_key;
    }
}