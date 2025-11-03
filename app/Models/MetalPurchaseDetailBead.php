<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetalPurchaseDetailBead extends Model
{
    use HasFactory;
    protected $fillable = [
        'metal_purchase_detail_id',
        'type',
        'product_id',
        'beads',
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

    public function metal_purchase_detail()
    {
        return $this->belongsTo(MetalPurchaseDetail::class, 'metal_purchase_detail_id');
    }

    public function product_name()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
