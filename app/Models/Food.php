<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'id_type',
        'image',
        'bestSeller',
        'cost',
        'detail',
        'status'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_foods', 'id_food', 'id_category');
    }
}
