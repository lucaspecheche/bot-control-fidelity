<?php

use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('tt', function () {

    dd(is_numeric('12a'));


})->describe('Display an inspiring quote');
