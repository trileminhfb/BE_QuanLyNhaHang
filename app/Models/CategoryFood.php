<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFood extends Model
{
    use HasFactory;
    protected $table = 'category_foods';

    protected $fillable = [
        'id_category',
        'id_food',
    ];
}

