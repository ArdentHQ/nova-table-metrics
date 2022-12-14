<?php

declare(strict_types=1);

namespace Ardenthq\NovaTableMetrics;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-table-metrics', __DIR__.'/../dist/js/card.js');
        });
    }

    protected function routes() : void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/nova-table-metrics')
                ->group(__DIR__.'/../routes/api.php');
    }
}
