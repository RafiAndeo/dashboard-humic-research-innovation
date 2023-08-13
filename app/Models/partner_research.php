<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner_research extends Model
{
    use HasFactory;

    protected $table = "partner_research";

    protected $fillable = [
        "partner_id",
        "research_id",
    ];
}
