<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailserti extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_sertifikasi';

    protected $table = 'detailserti';
    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = ['id_detail_sertifikasi', 'id_sertifikasi', 'nama_peserta', 'status'];

    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class, 'id_sertifikasi', 'id_sertifikasi');
    }
    
}
