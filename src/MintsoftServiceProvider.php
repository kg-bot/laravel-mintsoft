<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 2.4.18.
 * Time: 01.02
 */

namespace KgBot\Mintsoft;


use Illuminate\Support\ServiceProvider;

class MintsoftServiceProvider extends ServiceProvider
{
    /**
     * Boot.
     */
    public function boot()
    {
        $configPath = __DIR__ . '/config/mintsoft.php';

        $this->mergeConfigFrom( $configPath, 'mintsoft' );

        $configPath = __DIR__ . '/config/mintsoft.php';

        if ( function_exists( 'config_path' ) ) {

            $publishPath = config_path( 'mintsoft.php' );

        } else {

            $publishPath = base_path( 'config/mintsoft.php' );

        }

        $this->publishes( [ $configPath => $publishPath ], 'config' );
    }

    public function register()
    {
    }
}