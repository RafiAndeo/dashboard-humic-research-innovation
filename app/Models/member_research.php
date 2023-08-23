<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member_research extends Model
{
    use HasFactory;

    protected $table = "member_research";

    protected $fillable = [
        "member_id",
        "research_id",
        "role",
    ];
}