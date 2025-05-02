<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $table = 'rates';
    protected $fillable = [
        'id_food',
        'star',
        'detail',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }
}
