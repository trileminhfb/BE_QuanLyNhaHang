<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',        // OK
        'id_type',     // ✅ thay vì 'type'
        'id_category', // OK
        'cost',        // OK
        'detail',      // OK
        'status',      // OK
        'bestSeller'   // OK
    ];


    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_food', 'id_food', 'id_sale');
    }


    // public function carts()
    // {
    //     return $this->hasMany(Cart::class, 'id_food');
    // }
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }
}
