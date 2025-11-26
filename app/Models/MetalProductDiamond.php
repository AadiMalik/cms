<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetalProductDiamond extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_product_id',
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
        'deletedby_id'
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];

    public function metal_product()
    {
        return $this->belongsTo(MetalProduct::class, 'metal_product_id');
    }
}
