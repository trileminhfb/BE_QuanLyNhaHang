<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse_Invoce extends Model
{
    protected $table = 'warehouse_invoices';

    protected $fillable = [
        'id_ingredient',
        'quantity',
        'price',
    ];
}
