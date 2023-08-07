<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class research extends Model
{
    use HasFactory;

    protected $table = "research";

    protected $fillable = [
        'tahun_diterima',
        'tahun_berakhir',
        'judul',
        'tkt',
        'grant',
        'skema',
        'tipe_pendanaan',
        'pendanaan_external',
        'tipe_external',
        'lama_penelitian',
        'keterangan',
    ];
}