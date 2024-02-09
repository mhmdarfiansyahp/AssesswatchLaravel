<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    function index()
    {
        return view('login');
    }

    function login(Request $request){
        Session::flash('username', $request->Username);
    
        $request->validate([
            'Username' => 'required',
            'Password' => 'required'
        ],[
            'Username.required' => 'Username Wajib diisi',
            'Password.required' => 'Password Wajib diisi'
        ]);
    
        $username = $request->input('Username');
        $password = $request->input('Password');
    
        // Cari pengguna berdasarkan username
        $pengguna = Pengguna::where('username', $username)->first();
    
        if ($pengguna) {
            // Memeriksa apakah password sesuai dengan hash yang disimpan
            if (Hash::check($password, $pengguna->password)) {
                // Check if the user is active
                if ($pengguna->status == 'Aktif') {
                    // Autentikasi berhasil
                    Auth::guard('pengguna')->login($pengguna);
    
                    // Menyimpan informasi login
                    $request->session()->put('logged_in', $pengguna);
    
                    return redirect(route('Dashboard.index'))->with('success', 'Login Berhasil!');
                } else {
                    // User is not active
                    return redirect(route('login.index'))->with('error', 'Akun tidak aktif. Harap hubungi administrator.');
                }
            } else {
                // Password tidak sesuai
                return redirect(route('login.index'))->with('error', 'Password salah!');
            }
        } else {
            // Autentikasi gagal
            return redirect(route('login.index'))->with('error', 'Username atau Password Salah!');
        }
    }
    

    public function logout()
    {
        Auth::guard('pengguna')->logout();
        return redirect(route('login.index'))->with('success', 'Berhasil Logout');
    }
}

