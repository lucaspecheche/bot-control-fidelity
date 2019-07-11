<?php

use App\Facades\UserService;
use App\Models\User;
use Illuminate\Foundation\Inspiring;

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

    $dataUser = [
        'id_third_party' => 123123,
        'first_name'     => 'Lucas',
        'last_name'      =>  'Pecheche'
    ];

    $user = (new User())->findOrNew($dataUser);

    $dataChat = [
        'chat' => 12,
        'type' =>    'PRIVATE',
        'user_id' => $user->id
    ];

    $chat = ((new \App\Models\Chat())->create($dataChat));
    dd($chat->user);

})->describe('Display an inspiring quote');
