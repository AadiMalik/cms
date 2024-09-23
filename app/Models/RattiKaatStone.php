<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RattiKaatStone extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'category',
        'type',
        'ratti_kaat_id',
        'product_id',
        'stones',
        'gram',
        'carat',
        'gram_rate',
        'carat_rate',
        'total_amount',
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
