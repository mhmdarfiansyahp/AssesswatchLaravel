<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sertifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title ='Sertifikasi';
        $data = Sertifikasi::with('prodi')->get();
        return view ('sertifikasi.index',compact('title'),['sertifikasi' => $data],);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title ='Sertifikasi';
        $prodis = Prodi::all();
        return view ('sertifikasi.create',compact('title','prodis'));
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
            'id_prodi' => 'required',
            'nama_sertifikasi' => 'required|string|max:50',
            'tanggal_sertifikasi' => 'required',
            'lembaga' => 'required',
            'level' => 'required',
            // 'levelKKNI' => 'required',
            'buktipendukung' => 'required|mimes:pdf',
            'kompeten' => 'required',
            'tidakkompeten' => 'required',
            'tidakhadir' => 'required',
            'jumlah' => 'required',
            // 'tanggal_sertifikasi' => 'required'
        ], [
            'id_prodi.required' => 'Nama Prodi wajib diisi.',
            'nama_sertifikasi.required' => 'Nama Sertifikasi Wajib diisi.',
            'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
            'lembaga.required' => 'Lembaga Sertifikasi Wajib diisi.',            
            'level.required' => 'Level Sertifikasi Wajib diisi.',
            // 'levelKKNI.required' => 'Level KKNI Wajib diisi.',
            'buktipendukung.required' => 'Bukti Pendukung Wajib diunggah.',
            'buktipendukung.mimes' => 'Format file tidak valid. Harap pilih file PDF atau dokumen lainnya.',
            'kompeten.required' => 'Peserta Kompeten Wajib diisi.',
            'tidakkompeten.required' => 'Peserta Tidak Kompeten Wajib diisi.',
            'tidakhadir.required' => 'Peserta Tidak Hadir Wajib diisi.',
            // 'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
        ]);

        if ($request->hasFile('buktipendukung')) {
            $buktipendukung = $request->file('buktipendukung');
            $nama_buktipendukung = time() . '_' . $buktipendukung->getClientOriginalName(); // Tambahkan timestamp
    
            // Store the file with its original name
            $buktipendukung->storeAs('files', $nama_buktipendukung);
            $validateData['buktipendukung'] = $nama_buktipendukung;
        }

        Sertifikasi::create($validateData);
        return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi Berhasil Ditambahkan');
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
        // $title ='Sertifikasi';
        // $data = Sertifikasi::findOrFail($id);
        // $prodis = Prodi::all();
        // return view ('sertifikasi.edit',compact('title','prodis'),['sertifikasi' => $data]);
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
            'nama_sertifikasi' => 'required|string|max:50',
            'id_prodi' => 'required'
        ], [
            'nama_sertifikasi.required' => 'Nama Sertifikasi wajib diisi.',
            'id_prodi.required' => 'Nama Program Studi wajib diisi.'
        ]);

        $data = Sertifikasi::findOrFail($id);

        $data->update($validateData);

        return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Sertifikasi::findOrFail($id);

        $data->delete();

        return redirect()->route('sertifikasi.index')->with('success', 'Skema Deleted Successfully');
    }

    public function download($id)
    {
        $detailSertifikasi = Sertifikasi::find($id);
    
        if (!$detailSertifikasi) {
            return abort(404); // Atau sesuaikan dengan penanganan kesalahan Anda
        }
    
        // Ambil nama file dari atribut buktpendukung
        $filename = $detailSertifikasi->buktipendukung;
    
        // Cari posisi underscore pertama
        $underscorePos = strpos($filename, '_');
    
        // Jika underscore ditemukan, potong nama file dari underscore tersebut
        if ($underscorePos !== false) {
            $filename = substr($filename, $underscorePos + 1);
        }
    
        // Bangun path file
        $filepath = storage_path("app/files/{$detailSertifikasi->buktipendukung}");
    
        // Unduh file dengan nama yang telah dipotong
        return response()->download($filepath, $filename);
    }
    

    public function detaildata()
    {
        $detailserti = DB::select('CALL GetSertifikasiData()');
    
        return $detailserti;
    }
}
