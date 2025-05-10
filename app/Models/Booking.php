<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "timeBooking",
        "id_customer",
        "status",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    public function table()
    {
        return $this->belongsTo(Table::class, 'id_table');
    }
    public function bookingFoods()
    {
        return $this->hasMany(booking_food::class, 'id_booking');
    }
}
