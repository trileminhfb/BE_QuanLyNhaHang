<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryFood extends Model
{
    use HasFactory;
    protected $table = 'category_foods';

    protected $fillable = [
        'id_category',
        'id_food',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }
}
