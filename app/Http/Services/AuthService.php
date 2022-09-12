<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    /**
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function authorizationWithCredentials(array $credentials = [], bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * @param Authenticatable $model
     * @param bool $remember
     * @return void
     */
    public function authorizeModel(Authenticatable $model, bool $remember = false): void
    {
        Auth::login($model, $remember);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Session::flush();
        Auth::logout();
    }
}
