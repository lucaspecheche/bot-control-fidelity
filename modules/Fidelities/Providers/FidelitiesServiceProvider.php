<?php

namespace Fidelities\Providers;

use Illuminate\Support\ServiceProvider;

class FidelitiesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../translations/', 'fidelities');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/fidelitiesApi.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
    }
}
