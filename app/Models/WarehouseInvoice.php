<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseInvoice extends Model
{
    use HasFactory;
    protected $table = 'warehouse_invoices';
    protected $fillable = [
        'id_ingredient',
        'quantity',
        'price',
    ];
}
 
