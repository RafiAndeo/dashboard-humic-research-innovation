<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member_hki extends Model
{
    use HasFactory;

    protected $table = "member_hki";

    protected $fillable = [
        "member_id",
        "hki_id",
    ];
}
