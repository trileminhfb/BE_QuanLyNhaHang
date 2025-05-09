<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReportFood extends Model
{
    protected $table = 'sale_report_foods';

    protected $fillable = [
        'id_sale_report',
        'id_food',
        'quantity',
        'total_price'
    ];

    public function report()
    {
        return $this->belongsTo(SaleReport::class, 'id_sale_report');
    }
}

