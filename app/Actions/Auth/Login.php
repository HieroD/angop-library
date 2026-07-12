<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function handle(LoginRequest $request): bool
    {
        foreach (['staff', 'member'] as $guard) {
            if (Auth::guard($guard)->attempt($request->credentials())) {
                $request->session()->regenerate();

                return true;
            }
        }

        return false;
    }
}
