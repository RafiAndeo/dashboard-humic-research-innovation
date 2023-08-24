<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hki extends Model
{
    use HasFactory;

    protected $table = "hki";

    protected $fillable = [
        'tahun',
        'judul',
        'jenis',
        'status',
        'isVerified',
    ];
}