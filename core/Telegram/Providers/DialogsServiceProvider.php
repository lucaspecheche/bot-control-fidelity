<?php
namespace Telegram\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Telegram\Dialogs;
use Telegram\Telegram;


class DialogsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Dialogs::class, function ($app) {
            /** @var Container $app */
            return new Dialogs($app->make(Telegram::class), $app->make('redis'));
        });

        $this->app->alias(Dialogs::class, 'dialogs');
    }

    public function provides()
    {
        return ['dialogs', Dialogs::class];
    }
}
