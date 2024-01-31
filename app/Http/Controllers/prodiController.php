<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class prodiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title ='Program Studi';
        $data = Prodi::all();
        return view ('prodi.index',compact('title'),['prodi' => $data],);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $title ='Program Studi';
        return view ('prodi.create',compact('title'));
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
            'nama_prodi' => 'required|string|max:50|unique:prodi,nama_prodi',
        ], [
            'nama_prodi.required' => 'Nama Program Studi Wajib Diisi.',
            'nama_prodi.unique' => 'Nama Program Studi Sudah Ada.',
        ]);

        if (!isset($validateData['status'])) {
            $validateData['status'] = 'Aktif';
        }

        Prodi::create($validateData);
        return redirect()->route('prodi.index')->with('success', 'Program Studi Berhasil Ditambahkan');
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
        $title ='Program Studi';
        $data = Prodi::findOrFail($id);
        return view ('prodi.edit',compact('title'),['prodi' => $data]);
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
            'nama_prodi' => 'required|string|max:50',
            'status' => 'required|string|max:50', 
        ], [
            'nama_prodi.required' => 'Nama Program Studi Wajib Diisi.',
            'status.required' => 'Status wajib Diisi.',
        ]);

        $data = Prodi::findOrFail($id);

        $data->update($validateData);

        return redirect()->route('prodi.index')->with('success', 'Program Studi Berhasil Diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Prodi::findOrFail($id);
        $data->status = 'Tidak Aktif'; // Ubah status menjadi tidak aktif
        $data->save();
        
        return redirect()->route('prodi.index')->with('success', 'Program Studi Berhasil Dihapus');        
    }
}
