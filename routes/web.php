<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('/land/index.html');
});
