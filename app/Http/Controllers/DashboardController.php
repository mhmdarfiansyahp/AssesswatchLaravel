<?php

namespace App\Http\Controllers;

use App\Models\Detailserti;
use App\Models\Prodi;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use PDO;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dashboard';
        
        // $detail = Detailserti::join('sertifikasi as s', 's.id_sertifikasi', '=', 'detailserti.id_sertifikasi')
        // ->join('prodi as f', 'f.id_prodi', '=', 's.id_prodi')
        // ->select(
        //     'f.nama_prodi',
        //     DB::raw('COUNT(DISTINCT s.id_sertifikasi) AS jumlah_sertifikasi'),
        //     DB::raw('SUM(detailserti.status) AS jumlah_kompeten'),
        //     DB::raw('COUNT(*) - SUM(detailserti.status) AS jumlah_tidak_kompeten')
        // )
        // ->groupBy('f.nama_prodi')
        // ->get();    
        $prodiList = Prodi::all();
        $sertifikasiList = Sertifikasi::all();
        $data = Sertifikasi::with('prodi')->get();

        return view('Dashboard.index', compact('title', 'prodiList', 'sertifikasiList'),['sertifikasi' => $data]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $title = 'Dashboard';
        // $sertifikasiData = Sertifikasi::all();
        // $prodiData = Prodi::all();
    
        // return view('Dashboard.create', compact('title', 'sertifikasiData', 'prodiData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validateData = $request->validate([
        //     'id_sertifikasi' => 'required',
        //     'nama_peserta' => 'required|string|max:50',
        //     'status' => 'required'
        // ], [
        //     'id_sertifikasi.required' => 'Nama Sertifikasi wajib diisi.',
        //     'nama_peserta.required' => 'Nama Peserta Wajib diisi.',
        //     'status.required' => 'Status Wajib diisi.',
        // ]);
        // unset($validateData['id_prodi']);

        // Detailserti::create($validateData);
        // return redirect()->route('Dashboard.index')->with('success', 'Sertifikasi created successfully');    
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

    public function detaildata($year)
    {
        // Get the selected year from the request or use the current year if not provided
        // $selectedYear = $request->input('year', now()->year);
        $selectedYear = $year;

        // Fetch Sertifikasi data for the selected year
        $detailserti = DB::select('CALL GetSertifikasiDatayear(?)', [$selectedYear]);

    
        return $detailserti;
    }

    public function alldata()
    {
        $detailserti = DB::select('CALL GetKeseluruhanSertifikasi()');
    
        return $detailserti;
    }

    public function sertifilter($serti){
        $sertifikasi = $serti;

        $detailserti = DB::select('CALL GetSertifikasiCounts(?)', [$sertifikasi]);

    
        return $detailserti;
    }

    public function pilihSerti($id_prodi,$years)
    {
        $results = DB::connection()->select("SELECT id_sertifikasi, nama_sertifikasi FROM sertifikasi WHERE id_prodi = :id_prodi and YEAR(tanggal_sertifikasi) = :years", ['id_prodi' => $id_prodi,'years' => $years]);
    
        return $results;
    }

    public function sertifikasi($id_sertifikasi){

        $results = DB::connection()->select("SELECT nama_sertifikasi, kompeten, tidakkompeten, tidakhadir FROM sertifikasi WHERE id_sertifikasi = :id_sertifikasi", ['id_sertifikasi' => $id_sertifikasi]);

        return $results;
    }
    
    public function prodibytahun($prodi, $tahun){

        $results = DB::connection()->select("SELECT nama_sertifikasi, kompeten, tidakkompeten,tidakhadir FROM sertifikasi WHERE id_prodi = :prodi AND YEAR(tanggal_sertifikasi) = :tahun", ['prodi' => $prodi,'tahun' => $tahun]);

        return $results;
    }
}
