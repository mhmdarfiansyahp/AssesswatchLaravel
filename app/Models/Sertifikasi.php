<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }
    
    use HasFactory;

    protected $primaryKey = 'id_sertifikasi';

    protected $table = 'sertifikasi';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = ['id_sertifikasi','id_prodi','nama_sertifikasi','tanggal_sertifikasi','lembaga','level','buktipendukung','kompeten','tidakkompeten','tidakhadir','jumlah','status'];
    
    public function getNamaProdi($id_sertifikasi)
    {
        $nama_prodi = Sertifikasi::find($id_sertifikasi)->prodi->nama_prodi;

        return response()->json($nama_prodi);
    }
}
