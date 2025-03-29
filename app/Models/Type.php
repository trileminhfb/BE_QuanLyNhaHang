<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'type';

    protected $fillable = [
        'id_category',
        'status',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'id_type');
    }
}
