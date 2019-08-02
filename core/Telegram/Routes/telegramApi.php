<?php

use Illuminate\Support\Facades\Route;

Route::prefix('telegram')
    ->namespace('Telegram\Http\Controllers')
    ->group(function () {
    Route::post('setWebhook', 'WebHookTelegramController@setWebhook');
    Route::post('removeWebhook', 'WebHookTelegramController@removeWebhook');
    Route::post('updates', 'WebHookTelegramController@getUpdates');
});

Route::get('/me', 'HomeController@me');
