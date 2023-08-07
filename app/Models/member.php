<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;

    protected $table = "member";

    protected $fillable = [
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
    ];
}
