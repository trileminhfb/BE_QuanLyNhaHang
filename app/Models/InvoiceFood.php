<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceFood extends Model
{
    use HasFactory;

    protected $table = 'invoice_food';

    protected $fillable = [
        'id_food',
        'id_invoice',
        'quantity',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

