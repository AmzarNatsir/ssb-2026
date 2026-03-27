<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();


        $this->mapHrdRoutes();

        $this->mapWarehouseRoutes();

        $this->mapTenderRoutes();

        $this->mapHseRoutes();

        $this->mapWorkshopRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "hrd" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapHrdRoutes()
    {
        //Route::domain('hrd.'.env('APP_DOMAIN','ssb.pro'))
        //    ->middleware('web')
        //    ->namespace($this->namespace.'\Hrd')
        //    ->group(base_path('routes/hrd.php'));

        Route::middleware('web')
            ->prefix('hrd')
            ->namespace($this->namespace)
            ->group(base_path('routes/hrd.php'));
    }

    /**
     * Define the "Warehouse" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWarehouseRoutes()
    {
        Route::middleware('web')
            ->prefix('warehouse')
            ->namespace($this->namespace . '\Warehouse')
            ->group(base_path('routes/warehouse.php'));
    }

    /**
     * Define the "Tender" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapTenderRoutes()
    {
        Route::middleware('web')
            ->prefix('tender')
            ->namespace($this->namespace . '\Tender')
            ->group(base_path('routes/tender.php'));
    }

    /**
     * Define the "Hse" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapHseRoutes()
    {
        Route::middleware('web')
            ->prefix('hse')
            ->namespace($this->namespace . '\Hse')
            ->group(base_path('routes/hse.php'));
    }

    /**
     * Define the "Warehouse" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWorkshopRoutes()
    {
        Route::middleware('web')
            ->prefix('workshop')
            ->namespace($this->namespace . '\Workshop')
            ->group(base_path('routes/workshop.php'));
    }
}
