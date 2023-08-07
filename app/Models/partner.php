<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner extends Model
{
    use HasFactory;

    protected $table = "partner";

    protected $fillable = [
        "nama_partner",
        "sumber",
        "institusi",
        "jabatan",
        "negara",
        "type",
    ];
}