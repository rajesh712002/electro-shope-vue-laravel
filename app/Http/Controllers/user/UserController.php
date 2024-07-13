<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register()
    {
        return view('user.register');
    }

    public function login()
    {
        return view('user.login');
    }
}
