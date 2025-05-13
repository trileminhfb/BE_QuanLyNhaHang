<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Rank extends Model
{
    use HasFactory;

    protected $table = "ranks";

    protected $fillable = [
        "nameRank",
        "necessaryPoint",
        "saleRank",
        "image",  // Add this to allow mass-assignment
    ];

    public function getImageAttribute($value)
    {
        return ($value ? asset(Storage::url($value)) : null);
    }
}
