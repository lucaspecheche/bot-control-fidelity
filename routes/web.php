<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('/land/index.html');

});
Route::prefix('telegram')->group(function () {
    Route::post('setWebhook', 'WebHookController@setWebhook');
    Route::post('removeWebhook', 'WebHookController@removeWebhook');
    Route::post('updates', 'WebHookController@getUpdates');
});

Route::get('/me', 'HomeController@me');
