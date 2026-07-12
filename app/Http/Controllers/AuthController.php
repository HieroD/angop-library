<?php

namespace App\Http\Controllers;

use App\Actions\Auth\Login;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request, Login $login): RedirectResponse
    {
        if ($login->handle($request)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }
}
