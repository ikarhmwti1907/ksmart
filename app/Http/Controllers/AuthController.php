<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Cek apakah email ada
    if (!\App\Models\User::where('email', $request->email)->exists()) {
        return back()->with('error', 'Email tidak ditemukan!');
    }

    // Kirim pesan sukses (tanpa kirim email)
    return back()->with('success', 'Tautan reset password telah dikirim ke email Anda (simulasi).');
}

    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Berhasil logout!');
}

}