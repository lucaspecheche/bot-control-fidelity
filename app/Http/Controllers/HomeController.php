<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

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

    public function consulta()
    {
        return DB::table('table')->get();
    }
}
