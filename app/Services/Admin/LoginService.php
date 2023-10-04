<?php

namespace App\Services\Admin;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\Support\Facades\Auth;

class LoginService
{

    public function attempt($request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            throw new AuthenticationException(LOGIN_FAILED);
        }

        if (Auth::user()->role != ADMIN) {
            Auth::logout();
            throw new AuthorizationException(LOGIN_DONT_PERMISSION);
        }

        return true;
    }
}
