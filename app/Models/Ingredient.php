<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'ingredients';
    protected $fillable = [
        'name_ingredient',
        'image',
        'unit',
    ];

    public function getImageAttribute($value)
    {
        return ($value ? asset(Storage::url($value)) : null);
    }
}
