<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetalPurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_purchase_id',
        'product_id',
        'metal',
        'purity',
        'description',
        'scale_weight',
        'bead_weight',
        'stone_weight',
        'diamond_weight',
        'net_weight',
        'metal_rate',
        'metal_amount',
        'bead_amount',
        'stone_amount',
        'diamond_amount',
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

    public function metal_purchase_name()
    {
        return $this->belongsTo(MetalPurchase::class, 'metal_purchase_id');
    }

    public function product_name()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
