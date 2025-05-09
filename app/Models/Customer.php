<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rank;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'customers';

    protected $fillable = [
        'phoneNumber',
        'mail',
        'birth',
        'password',
        'FullName',
        'image',
        'otp',
        'point',
        'id_rank',
        'isActive',
    ];
    protected $casts = [
        'birth' => 'date',
        'isActive' => 'boolean',
        'point' => 'integer',
    ];
    public function rank()
    {
        return $this->belongsTo(Rank::class, 'id_rank');
    }
    public function getBirthAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
