<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "invoices";
    protected $fillable = [
        'id_table',
        'timeEnd',
        'total',
        'id_user',
        'id_customer',
        'id_sale'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'id_table');
    }
}
