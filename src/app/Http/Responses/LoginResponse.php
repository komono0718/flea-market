<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Providers\RouteServiceProvider;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],

            'password' => ['required'],
        ];
    }
}
