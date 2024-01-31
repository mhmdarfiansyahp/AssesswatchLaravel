<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class pengguna extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';

    protected $table = 'penggunas';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_user','nama','username','password','role','status'];
}
