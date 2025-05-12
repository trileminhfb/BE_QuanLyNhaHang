<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReport extends Model
{
    protected $table = 'sale_report';

    protected $fillable = [
        'report_type',
        'report_date',
        'total_revenue',
        'total_orders',
        'top_food_name',
        'top_food_quantity'
    ];

    public function foods()
    {
        return $this->hasMany(SaleReportFood::class, 'id_sale_report');
    }
}
