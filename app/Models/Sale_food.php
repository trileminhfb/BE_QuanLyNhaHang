<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_food extends Model
{
    use HasFactory;

    protected $table = 'sale_foods';

    protected $fillable = ['id_food', 'id_sale'];

    public $timestamps = false;
}
