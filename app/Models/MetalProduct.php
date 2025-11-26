<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetalProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_purchase_id',
        'metal_purchase_detail_id',
        'finish_product_location_id',
        'tag_no',
        'parent_id',
        'is_parent',
        'barcode',
        'product_id',
        'warehouse_id',
        'picture',
        'metal',
        'purity',
        'metal_rate',
        'scale_weight',
        'bead_weight',
        'stones_weight',
        'diamond_weight',
        'net_weight',
        'gross_weight',
        'bead_price',
        'stones_price',
        'diamond_price',
        'total_metal_amount',
        'total_bead_amount',
        'total_stones_amount',
        'total_diamond_amount',
        'other_charges',
        'total_amount',
        'is_active',
        'is_saled',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];
    public function MetalProduct()
    {
        return $this->belongsToMany(MetalProduct::class);
    }
    public function parent_name()
    {
        return $this->belongsTo(MetalProduct::class, 'parent_id');
    }
    public function metal_purchase()
    {
        return $this->belongsTo(MetalPurchase::class, 'metal_purchase_id');
    }

    public function metal_purchase_detail()
    {
        return $this->belongsTo(MetalPurchaseDetail::class, 'metal_purchase_detail_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function finish_product_location()
    {
        return $this->belongsTo(FinishProductLocation::class, 'finish_product_location_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
