<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Voyager::addAction(\App\Actions\VentaDetalle::class);
        // Voyager::addAction(\App\Actions\VentaRecibo::class);

        Voyager::addAction(\App\Actions\ProductionDetalle::class);
        // Voyager::addAction(\App\Actions\ProductionRecibo::class);

        // Voyager::addAction(\App\Actions\ProductionSemiDetalle::class);
        // Voyager::addAction(\App\Actions\ProductionSemiRecibo::class);

        // Voyager::addAction(\App\Actions\ProductoDetalle::class);

        Voyager::addAction(\App\Actions\CajaDetalle::class);

    }
}
