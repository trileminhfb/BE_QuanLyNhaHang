<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';

    protected $fillable = [
        'id_food',
        'star',
        'detail',
    ];
}
