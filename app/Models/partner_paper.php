<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner_paper extends Model
{

    protected $table = "partner_paper";

    protected $fillable = [
        "partner_id",
        "paper_id",
    ];
    use HasFactory;
}
