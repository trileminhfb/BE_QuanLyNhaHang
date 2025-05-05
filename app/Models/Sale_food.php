<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_food extends Model
{
    use HasFactory;

    protected $table = 'sale_foods';

    protected $fillable = [
        'id_food',
        'id_sale'
    ];

    public $timestamps = false;

    public function foods()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }

    // Quan hệ với model Sale
    public function sales()
    {
        return $this->belongsTo(Sale::class, 'id_sale');
    }

}
