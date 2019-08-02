<?php

namespace Telegram\Providers;

use Illuminate\Support\ServiceProvider;
use Telegram\Telegram;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Translations', 'telegram');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/telegramApi.php');
    }

    public function register()
    {
        $this->registerTelegram();
    }

    protected function registerTelegram()
    {
        $this->app->singleton(Telegram::class, function ($app) {

            $telegram = new Telegram(
                config('telegram.bot_token', false),
                config('telegram.async_requests', false),
                config('telegram.http_client_handler', null)
            );

            $telegram->addCommands(config('telegram.commands', []));

            if (config('telegram.inject_command_dependencies', false)) {
                $telegram->setContainer($app);
            }

            return $telegram;
        });

        $this->app->alias(Telegram::class, 'telegram');
    }

    public function provides()
    {
        return ['telegram', Telegram::class];
    }
}
