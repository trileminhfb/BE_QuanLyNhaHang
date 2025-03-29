<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = [
        'id_food',
        'id_table',
        'quantity',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }


    public function table()
    {
        return $this->belongsTo(Table::class, 'id_table');
    }
}
