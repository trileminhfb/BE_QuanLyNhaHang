<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getImageAttribute($value)
    {
        return ($value ? asset(Storage::url($value)) : null);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }

    public function categoryFoods()
    {
        return $this->hasMany(CategoryFood::class, 'id_food');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_foods', 'id_food', 'id_category');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_food', 'id_food', 'id_invoice')
            ->withPivot('quantity');
    }

}
