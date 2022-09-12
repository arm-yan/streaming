<?php

namespace App\Http\Controllers;

class UserController
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('registration');
    }
}
