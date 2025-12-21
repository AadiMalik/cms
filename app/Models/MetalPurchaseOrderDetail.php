<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetalPurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_purchase_order_id',
        'product_id',
        'category',
        'design_no',
        'metal',
        'purity',
        'net_weight',
        'description',
        'is_deleted',
        'createdby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];
    public function metal_purchase_order()
    {
        return $this->belongsTo(MetalPurchaseOrder::class, 'metal_purchase_order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
