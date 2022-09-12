<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UserController
{
    /**
     * @return View
     */
    public function dashboard(): View
    {
        return view('dashboard');
    }

    /**
     * @return View
     */
    public function login(): View
    {
        return view('login');
    }

    /**
     * @return View
     */
    public function register(): View
    {
        return view('registration');
    }
}
