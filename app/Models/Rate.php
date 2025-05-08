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
        'id_customer',
        'star',
        'detail',
        'time',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
}
