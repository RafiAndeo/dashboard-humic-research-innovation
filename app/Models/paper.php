<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paper extends Model
{
    use HasFactory;

    protected $table = "paper";

    protected $fillable = [
        "jenis",
        "judul",
        "member",
        "nama_jurnal",
        "issue",
        "volume",
        "tahun",
        "quartile",
        "index",
        "link",
    ];
}