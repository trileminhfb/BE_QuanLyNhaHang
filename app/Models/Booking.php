<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_table',
        'timeBooking',
        'id_food',
        'quantity',
        'id_cutomer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cutomer');
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'id_table');
    }
}
