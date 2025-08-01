<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleUsedGold extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'sale_id',
        'type',
        'weight',
        'kaat',
        'pure_weight',
        'karat',
        'rate',
        'amount',
        'description'
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
