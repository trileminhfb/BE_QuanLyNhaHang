<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking_food extends Model
{
    protected $table = 'booking_foods';

    protected $fillable = ['id_booking', 'id_foods', 'quantity'];


    public function food()
    {
        return $this->belongsTo(Food::class, 'id_foods');
    }
        public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
