<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member_paper extends Model
{
    use HasFactory;

    protected $table = "member_paper";

    protected $fillable = [
        "member_id",
        "paper_id",
        "role",
    ];
}