<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_prodi';

    protected $table = 'prodi';

    public $incrementing = true;

    protected $fillable = ['id_prodi','nama_prodi','status'];
}
