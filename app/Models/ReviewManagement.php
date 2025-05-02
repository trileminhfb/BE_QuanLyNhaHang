<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewManagement extends Model
{
    use HasFactory;
    protected $table = 'review__management';
    protected $fillable = [
        'id_rate',
        'id_user',
        'comment',
    ];

}
