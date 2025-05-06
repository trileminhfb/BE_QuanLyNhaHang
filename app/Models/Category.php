<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'id_type',
        'name',
        'status',
    ];


    public function types()
    {
        return $this->hasMany(Type::class, 'id_categories');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'id_categories');
    }
    public function categoryFoods()
    {
        return $this->hasMany(CategoryFood::class, 'id_category');
    }
}
