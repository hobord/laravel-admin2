<?php

namespace Hobord\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Hobord\Admin\Console\Commands\Setup;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Contracts\Http\Kernel $kernel)
    {
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/hobord/admin'),
        ], 'resources');

        $this->publishes([
            __DIR__.'/resources/assets' => resource_path('assets/vendor/hobord/admin'),
        ], 'resources');

        $this->publishes([
            __DIR__.'/public' => public_path('hobord-admin'),
        ], 'public');

//        $this->loadViewsFrom(__DIR__.'/resources/views', 'admin');
//
//        $this->publishes([
//            __DIR__.'/config/admin.php' => config_path('admin.php'),
//            __DIR__.'/resources/assets/css' => public_path('hobord/admin/css'),
//            __DIR__.'/resources/assets/js/dist' => public_path('hobord/admin/js')
//        ]);

        $this->registerSetupCommand();
        $this->setupRoutes($this->app->router);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the 'eternaltree:install' command.
     *
     * @return void
     */
    protected function registerSetupCommand()
    {

        $this->commands('command.admin.setup');
        $this->app->singleton('command.admin.setup', function ($app) {

            return new Setup();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.admin.setup'
        ];
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Hobord\Admin\Http\Controllers'], function($router) {

            $router->group([
                'middleware' => 'web',
            ], function ($router) {
                include __DIR__ . '/routes/web.php';
            });

//            $router->group([
//                'middleware' => 'api',
//            ], function ($router) {
//                include __DIR__.'/routes/api.php';
//            });

        });

    }

}