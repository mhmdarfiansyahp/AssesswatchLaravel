<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class pengguna extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    protected $table = 'penggunas';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_user','nama','username','password','role','status'];
}
