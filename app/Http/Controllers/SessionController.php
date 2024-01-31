<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        echo 'alert(' . $request->Username . ');';
        echo 'alert(' . $request->Password . ');';

        $info =[
            'username' => $request->get('Username'),
            'password' => $request->get('Password')
        ];

        $username = $request->get('Username');
        $password = $request->get('Password');

    
        // Cari pengguna dengan huruf pertama dari username dan password
        $pengguna = pengguna::where('username', 'like', $username . '%')
                            ->where('password', 'like', $password . '%')
                            ->first();

        if ($pengguna) {
            if ($pengguna->password == $password) {
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
        // if($pengguna){
        //     Auth::guard('pengguna')->login($pengguna);

        //     $request->session()->put('logged_in',$pengguna);

        //     return redirect(route('Dashboard.index'))->with('success', 'Login Berhasil!');
        // }else {
        //     // User is not active
        //     return redirect(route('login.index'))->with('error', 'Username atau Password Salah!');            ;
        // }
        // if($request->Username == "Admin" && $request->Password == "Admin"){
        //     return redirect(route('Dashboard.index'));
        // } else {
        //     return redirect('login.index')->with('error','wrong Password');
        // }
    }

    public function logout()
    {
        Auth::guard('pengguna')->logout();
        return redirect(route('login.index'))->with('success', 'Berhasil Logout');
    }
}

