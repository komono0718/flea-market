<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('verification.notice');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],

            'email' => ['required', 'email'],

            'password' => ['required', 'string', 'min:8'],

            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ];
    }
}

