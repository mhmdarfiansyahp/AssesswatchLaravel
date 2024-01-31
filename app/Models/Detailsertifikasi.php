<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsertifikasi extends Model
{
    use HasFactory;
    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class, 'id_sertifikasi', 'id_sertifikasi');
    }
    protected $primaryKey = 'id_detail_sertifikasi';

    protected $table = 'detailsertifikasi';

    public $timestamps = false;

    public $incrementing = true;
    

    protected $fillable = ['id_detail_sertifikasi','id_sertifikasi','tanggal_sertifikasi','lembaga','level','levelKKNI','buktipendukung'];
}
