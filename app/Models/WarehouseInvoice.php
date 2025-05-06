<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseInvoice extends Model
{
    use HasFactory;
    protected $table = 'warehouse__invoices';
    protected $fillable = [
        'id_ingredient',
        'quantity',
        'price',
        'stock_in_date',
    ];
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_ingredient');
    }
}
