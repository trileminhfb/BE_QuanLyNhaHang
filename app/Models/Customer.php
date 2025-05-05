<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rank; // ✅ Import Rank model

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = [
        "phoneNumber",
        "FullName",
        "image",
        "otp",
        "point",
        "id_rank",
    ];
    
    public function rank()
    {
        return $this->belongsTo(Rank::class, 'id_rank');
    }
}
