<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RattiKaatDiamond extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ratti_kaat_id',
        'product_id',
        'diamonds',
        'type',
        'cut',
        'color',
        'clarity',
        'carat',
        'carat_rate',
        'total_amount',
        'total_dollar',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];

    public function ratti_kaat_name()
    {
        return $this->belongsTo(RattiKaat::class, 'ratti_kaat_id');
    }
    public function product_name()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
