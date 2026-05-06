<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }
    
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email', // Sesuaikan dengan name di blade tadi
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard'); // Pastikan route /dashboard sudah ada
    }

    return back()->withErrors(['email' => 'Login gagal, periksa kembali data Anda.']);
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }

   // Tambahkan tanda tanya (?) sebelum string agar bisa menerima nilai null
private function redirectByRole(?string $role) 
{
    return match ($role) {
        'admin'  => redirect()->intended(route('admin.dashboard')),
        'siswa'  => redirect()->intended(route('siswa.dashboard')),
        default  => redirect('/dashboard'), // Arahkan ke dashboard umum jika role kosong
    };
}
}