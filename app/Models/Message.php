<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'id_user',
        'content',
        'sender',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
