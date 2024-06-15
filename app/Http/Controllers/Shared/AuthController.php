<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        /**
         * in login process, username and password must be filled
         */
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        /**
         * Take only username and password from user data request
         */
        $credential = $request->only('username', 'password');

        /**
         * if user data is not valid
         */
        if (!Auth::attempt($credential)) {
            return redirect('login')
                ->withInput()
                ->withErrors(['login_failed' => 'Pastikan kembali username dan password yang dimasukan sudah benar']);
        }

        $request->session()->regenerate();

        return redirect()->intended(match (Auth::user()->level) {
            /**
             * if user has admin roles
             */
            'admin' => 'admin',
            /**
             * if user has kader roles
             */
            'kader' => 'kader',
            /**
             * if user has ketua roles
             */
            'ketua' => 'ketua',
            /**
             * if user has no roles, back to landing Page
             */
            default => '/',
        });
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'logout');
    }
}
