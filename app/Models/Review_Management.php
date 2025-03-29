<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review_Management extends Model
{
    protected $table = 'review_management';

    protected $fillable = [
        'id_rate',
        'comment',
        'id_user',
    ];

}
