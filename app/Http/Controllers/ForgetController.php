<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgetController extends Controller
{
    function index()
    {
        return view('forget');
    }

    function resetPassword(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required', // Minimal 8 karakter
        ],[
            'Username.required' => 'Username Wajib diisi',
            'Password.required' => 'Password Wajib diisi',
        ]);

        $pengguna = pengguna::where('username', $request->Username)->first();

        if ($pengguna) {
            // Ubah password pengguna dalam database tanpa hashing
            $this->changePassword($pengguna, $request->Password);

            // Autentikasi ulang pengguna dengan password baru
            Auth::login($pengguna);

            return redirect(route('login.index'))->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        } else {
            return redirect(route('forget.index'))->with('error', 'Username tidak ditemukan.');
        }
    }

    // Fungsi untuk mengubah password pengguna dalam database tanpa hashing
    private function changePassword($user, $newPassword)
    {
        // Simpan password baru tanpa meng-hash
        $user->password = $newPassword;
        $user->save();
    }
}
