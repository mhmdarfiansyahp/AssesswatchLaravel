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
            'tanggal_sertifikasi' => ['required', 'date', function ($attribute, $value, $fail) {
                $fiveYearsAgo = now()->subYears(4);
                if ($value < $fiveYearsAgo->format('Y-m-d')) {
                    $fail("Tanggal sertifikasi tidak boleh lebih dari 5 tahun yang lalu.");
                }
            }],
            'lembaga' => 'required',
            'level' => 'required',
            'buktipendukung' => 'required|mimes:pdf',
            'kompeten' => 'required',
            'tidakkompeten' => 'required',
            'tidakhadir' => 'required',
            'jumlah' => 'required',
        ], [
            'id_prodi.required' => 'Nama Prodi wajib diisi.',
            'nama_sertifikasi.required' => 'Nama Sertifikasi Wajib diisi.',
            'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
            'tanggal_sertifikasi.date' => 'Format tanggal tidak valid.',
            'lembaga.required' => 'Lembaga Sertifikasi Wajib diisi.',            
            'level.required' => 'Level Sertifikasi Wajib diisi.',
            'buktipendukung.required' => 'Bukti Pendukung Wajib diunggah.',
            'buktipendukung.mimes' => 'Format file tidak valid. Harap pilih file PDF atau dokumen lainnya.',
            'kompeten.required' => 'Peserta Kompeten Wajib diisi.',
            'tidakkompeten.required' => 'Peserta Tidak Kompeten Wajib diisi.',
            'tidakhadir.required' => 'Peserta Tidak Hadir Wajib diisi.',
        ]);
    
        if ($request->hasFile('buktipendukung')) {
            $buktipendukung = $request->file('buktipendukung');
            $nama_buktipendukung = $buktipendukung->getClientOriginalName(); // Menggunakan nama asli file
        
            // Simpan file dengan nama asli
            $buktipendukung->storeAs('files', $nama_buktipendukung);
            $validateData['buktipendukung'] = $nama_buktipendukung;
        }        
    
        if (!isset($validateData['status'])) {
            $validateData['status'] = 'Tersedia';
        }
    
        // Mengecek apakah ada data dengan ID yang sama dengan yang dimasukkan
        $existingData = Sertifikasi::where('id_prodi', $validateData['id_prodi'])->first();
    
        // Jika ada data yang sudah ada di database dengan ID yang sama
        if ($existingData) {
            if ($existingData->nama_sertifikasi != $validateData['nama_sertifikasi'] ||
                $existingData->tanggal_sertifikasi != $validateData['tanggal_sertifikasi'] ||
                $existingData->lembaga != $validateData['lembaga'] ||
                $existingData->level != $validateData['level'] ||
                $existingData->kompeten != $validateData['kompeten'] ||
                $existingData->tidakkompeten != $validateData['tidakkompeten'] ||
                $existingData->tidakhadir != $validateData['tidakhadir'] 
            ) {
                Sertifikasi::create($validateData);
                return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi Berhasil Ditambahkan');
            } else {
                // Jika tidak ada perbedaan, kembalikan dengan pesan kesalahan
                return redirect()->back()->withErrors([
                    'nama_sertifikasi' => 'Sertifikasi dengan nama ini sudah terdaftar.',
                    'tanggal_sertifikasi' => 'Sertifikasi pada tanggal ini sudah terdaftar.',
                    'lembaga' => 'Sertifikasi dari lembaga ini sudah terdaftar.',
                    'level' => 'Sertifikasi dengan nama ini sudah terdaftar.',
                    'kompeten' => 'Sertifikasi dengan nama ini sudah terdaftar.',
                    'tidakkompeten' => 'Datanya sudah ada.',
                    'tidakhadir' => 'Datanya sudah ada.'
                ]);
            }
        } else {
            // Jika tidak ada data dengan ID yang sama, simpan data baru
            Sertifikasi::create($validateData);
            return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi Berhasil Ditambahkan');
        }
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
        $title ='Sertifikasi';
        $data = Sertifikasi::findOrFail($id);
        $prodis = Prodi::all();
        return view ('sertifikasi.edit',compact('title','prodis'),['sertifikasi' => $data]);
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
            'id_prodi' => 'required',
            'nama_sertifikasi' => 'required|string|max:50',
            'tanggal_sertifikasi' => ['required', 'date', function ($attribute, $value, $fail) {
                $fiveYearsAgo = now()->subYears(4);
                if ($value < $fiveYearsAgo->format('Y-m-d')) {
                    $fail("Tanggal sertifikasi tidak boleh lebih dari 5 tahun yang lalu.");
                }
            }],
            'lembaga' => 'required',
            'level' => 'required',
            'buktipendukung' => 'required|mimes:pdf',
            'kompeten' => 'required',
            'tidakkompeten' => 'required',
            'tidakhadir' => 'required',
            'jumlah' => 'required',
            'status' => 'required|string|max:50', 
            // 'tanggal_sertifikasi' => 'required'
        ], [
            'id_prodi.required' => 'Nama Prodi wajib diisi.',
            'nama_sertifikasi.required' => 'Nama Sertifikasi Wajib diisi.',
            'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
            'tanggal_sertifikasi.date' => 'Format tanggal tidak valid.',
            'lembaga.required' => 'Lembaga Sertifikasi Wajib diisi.',            
            'level.required' => 'Level Sertifikasi Wajib diisi.',
            // 'levelKKNI.required' => 'Level KKNI Wajib diisi.',
            'buktipendukung.required' => 'Bukti Pendukung Wajib diunggah.',
            'buktipendukung.mimes' => 'Format file tidak valid. Harap pilih file PDF atau dokumen lainnya.',
            'kompeten.required' => 'Peserta Kompeten Wajib diisi.',
            'tidakkompeten.required' => 'Peserta Tidak Kompeten Wajib diisi.',
            'tidakhadir.required' => 'Peserta Tidak Hadir Wajib diisi.',
            'status.required' => 'Status wajib Diisi.',
            // 'tanggal_sertifikasi.required' => 'Tanggal Wajib diisi.',
        ]);

        if ($request->hasFile('buktipendukung')) {
            $buktipendukung = $request->file('buktipendukung');
            $nama_buktipendukung = $buktipendukung->getClientOriginalName(); // Menggunakan nama asli file
        
            // Simpan file dengan nama asli
            $buktipendukung->storeAs('files', $nama_buktipendukung);
            $validateData['buktipendukung'] = $nama_buktipendukung;
        }     

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
        $data->status = 'Tidak Tersedia'; // Ubah status menjadi tidak aktif
        $data->save();

        return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi Deleted Successfully');
    }

    // public function download($id)
    // {
    //     $detailSertifikasi = Sertifikasi::find($id);
    
    //     if (!$detailSertifikasi) {
    //         return abort(404); // Atau sesuaikan dengan penanganan kesalahan Anda
    //     }
    
    //     // Ambil nama file dari atribut buktpendukung
    //     $filename = $detailSertifikasi->buktipendukung;
    
    //     // Cari posisi underscore pertama
    //     $underscorePos = strpos($filename, '_');
    
    //     // Jika underscore ditemukan, potong nama file dari underscore tersebut
    //     if ($underscorePos !== false) {
    //         $filename = substr($filename, $underscorePos + 1);
    //     }
    
    //     // Bangun path file
    //     $filepath = storage_path("app/files/{$detailSertifikasi->buktipendukung}");
    
    //     // Unduh file dengan nama yang telah dipotong
    //     return response()->download($filepath, $filename);
    // }
    
    public function showPdf($id)
    {
        $detailSertifikasi = Sertifikasi::find($id);
        
        if (!$detailSertifikasi) {
            return abort(404); // Atau sesuaikan dengan penanganan kesalahan Anda
        }
        
        // Bangun path file
        $filePath = storage_path("app/files/{$detailSertifikasi->buktipendukung}");
    
        // Jika file tidak ada, kembalikan respons 404
        if (!file_exists($filePath)) {
            return abort(404);
        }
    
        // Baca konten PDF
        $pdfContent = file_get_contents($filePath);
    
        // Return view untuk menampilkan PDF, serta meneruskan variabel $detailSertifikasi
        return view('sertifikasi.pdf')->with(['pdfContent' => $pdfContent, 'detailSertifikasi' => $detailSertifikasi]);
    }
    

    public function detaildata()
    {
        $detailserti = DB::select('CALL GetSertifikasiData()');
    
        return $detailserti;
    }
}
