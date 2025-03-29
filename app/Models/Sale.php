<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'nameSale', 'status', 'startTime', 'endTime', 'percent'
    ];


    public function foods()
    {
        return $this->belongsToMany(Food::class, 'sale_foods', 'id_sale', 'id_food');
    }
}
