<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = [
        'name',
        'status',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id_type'); // 1 type => 1 category
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'id_type');
    }
}
