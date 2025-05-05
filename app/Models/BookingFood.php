<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFood extends Model
{
    protected $table = 'boongking_foods'; // Specify the correct table name
    
    protected $fillable = ['id_foods', 'quantity', 'id_booking'];
}
