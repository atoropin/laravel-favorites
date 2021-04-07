<?php

namespace Rir\Favorites;

use Illuminate\Support\ServiceProvider;

/**
 * Class UnitellerServiceProvider
 * @package App\Providers
 */
class FavoriteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();

        $this->registerConfig();
    }

    /**
     * Register the package's publishable migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        $this->publishes([
            __DIR__.'/../migrations/create_favorites_table.php' => database_path('migrations/'.date('Y_m_d_His').'_create_favorites_table.php'),
        ], 'migrations');
    }

    /**
     * Register the package's publishable config.
     *
     * @return void
     */
    private function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/favorites.php' => config_path('favorites.php')
        ], 'favorites-config');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::namespace('Rir\Favorites\Controllers')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes.php');
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
