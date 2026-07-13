<?php

namespace App\Http\Controllers;

use App\Actions\Auth\Login;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, Login $login): RedirectResponse
    {
        if ($login->handle($request)) {
            if (auth('staff')->check()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth('staff')->logout();
        auth('member')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
