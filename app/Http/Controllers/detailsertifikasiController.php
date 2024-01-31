<?php

namespace App\Http\Controllers;

use App\Models\Detailsertifikasi;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;

class detailsertifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title ='Detail Sertifikasi';
        $data = Detailsertifikasi::with('sertifikasi')->get();
        return view ('detailsertifikasi.index',compact('title'),['dsertifikasi' => $data],);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title ='Detail Sertifikasi';
        $serti = Sertifikasi::all();
        return view ('detailsertifikasi.create',compact('title','serti'));
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
            'id_sertifikasi' => 'required',
            'tanggal_sertifikasi' => 'required',
            'lembaga' => 'required',
            'level' => 'required',
            'levelKKNI' => 'required',
            'buktipendukung' => 'required|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
        ], [
            'id_sertifikasi.required' => 'Nama Sertifikasi wajib diisi.',
            'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
            'lembaga.required' => 'Lembaga Sertifikasi Wajib diisi.',            
            'level.required' => 'Level Sertifikasi Wajib diisi.',
            'levelKKNI.required' => 'Level KKNI Wajib diisi.',
            'buktipendukung.required' => 'Bukti Pendukung Wajib diunggah.',
            'buktipendukung.mimes' => 'Format file tidak valid. Harap pilih file PDF atau dokumen lainnya.',
        ]);
        
        if ($request->hasFile('buktipendukung')) {
            $buktipendukung = $request->file('buktipendukung');
            $nama_buktipendukung = time() . '_' . $buktipendukung->getClientOriginalName(); // Tambahkan timestamp
    
            // Store the file with its original name
            $buktipendukung->storeAs('files', $nama_buktipendukung);
            $validateData['buktipendukung'] = $nama_buktipendukung;
        }
        
        Detailsertifikasi::create($validateData);
        return redirect()->route('detailsertifikasi.index')->with('success', 'Sertifikasi Berhasil Ditambahkan');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id)
    {
        $detailSertifikasi = Detailsertifikasi::find($id);

        if (!$detailSertifikasi) {
            return abort(404); // Atau sesuaikan dengan penanganan kesalahan Anda
        }

        $filepath = storage_path("app/files/{$detailSertifikasi->buktipendukung}");

        return response()->download($filepath);
    }
}
