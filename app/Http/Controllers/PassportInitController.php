<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PassportInitController extends Controller
{
    //

    public function index() {
//        Artisan::call('passport:install');
        shell_exec('php ../artisan passport:install');
    }
}
