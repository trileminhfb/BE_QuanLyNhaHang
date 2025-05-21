<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReportFood extends Model
{
    protected $table = 'sale_report_foods';

    protected $fillable = [
        'id_food',
        'id_sale_report',
        'quantity',
        'total_price'
    ];

    public function report()
    {
        return $this->belongsTo(SaleReport::class, 'id_sale_report');
    }


    public function food()
    {
        return $this->belongsTo(Food::class, 'id_food');
    }

}

