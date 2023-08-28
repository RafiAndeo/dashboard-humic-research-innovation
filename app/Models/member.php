<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class member extends Authenticatable
{
    use HasFactory;

    protected $table = "member";

    protected $fillable = [
        "id",
        "nama",
        "fakultas",
        "pendidikan",
        "bidang_ilmu",
        "jabatan",
        "kelompok_keahlian",
        "email",
        "photo",
        "membership",
        "status",
        "NIP",
        "role",
        "password",
    ];

    protected $hidden = [
        'remember_token',
    ];
}
