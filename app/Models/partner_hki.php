<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner_hki extends Model
{
    use HasFactory;

    protected $table = "partner_hki";

    protected $fillable = [
        "partner_id",
        "hki_id",
        "role",
    ];
}