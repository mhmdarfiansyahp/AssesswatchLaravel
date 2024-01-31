<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title ='Pengguna';
        $data = pengguna::all();
        return view ('pengguna.index',compact('title'),['pengguna' => $data],);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title ='Pengguna';
        return view ('pengguna.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|string|max:50',
            'nama' => 'required|string|max:50',
            'password' => 'required|string|max:50',
        ], [
            'username.required' => 'Username Wajib Diisi.',
            'nama.required' => 'Nama Pengguna Wajib Diisi.',
            'password.required' => 'Password Wajib Diisi.',
        ]);

        if (!isset($validateData['status'])) {
            $validateData['status'] = 'Aktif';
        }

        if (!isset($validateData['role'])) {
            $validateData['role'] = 'Admin';
        }

        pengguna::create($validateData);
        return redirect()->route('pengguna.index')->with('success', 'Pengguna Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title ='Pengguna';
        $data = pengguna::findOrFail($id);
        return view ('pengguna.edit',compact('title'),['pengguna' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'status' => 'required|string|max:50', 
        ], [
            'nama.required' => 'Nama Lengkap Wajib Diisi.',
            'username.required' => 'Username Wajib Diisi.',
            'password.required' => 'Password Wajib Diisi.',
            'status.required' => 'Status wajib Diisi.',
        ]);

        $data = pengguna::findOrFail($id);

        $data->update($validateData);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna Berhasil Diubah');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = pengguna::findOrFail($id);
        $data->status = 'Tidak Aktif'; // Ubah status menjadi tidak aktif
        $data->save();
        
        return redirect()->route('pengguna.index')->with('success', 'Pengguna Berhasil dihapus'); 
    }
}
