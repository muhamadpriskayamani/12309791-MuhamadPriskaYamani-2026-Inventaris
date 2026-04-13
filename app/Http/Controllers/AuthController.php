<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')
                ->with('success', 'Welcome ' . ucfirst(Auth::user()->role));
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing_page')->with('success', 'Logout berhasil');
    }
}
