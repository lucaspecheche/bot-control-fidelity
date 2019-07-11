<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return view('home');
    }

    public function info()
    {
        phpinfo();
    }

    public function me()
    {
        $response = Telegram::getMe();
        dd($response);
    }
}
