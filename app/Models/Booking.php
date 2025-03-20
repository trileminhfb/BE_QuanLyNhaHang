<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = "bookings";
    protected $fillable = [
        "id_table",
        "timeBooking",
        "id_food",
        "quantity",
        "id_cutomer",
    ];
}
