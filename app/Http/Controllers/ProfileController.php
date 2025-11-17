<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Kirim ke view
        return view('profile.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
 
    }

    public function edit()
{
    $user = Auth::user();
    return view('profile.edit', compact('user'));
}

}