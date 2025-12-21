<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MetalPurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_purchase_order_no',
        'metal_purchase_order_date',
        'reference_no',
        'metal_delivery_date',
        'approvedby_id',
        'supplier_id',
        'warehouse_id',
        'metal_sale_order_id',
        'total_qty',
        'status',
        'is_complete',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];
    protected static function booted()
    {
        static::addGlobalScope('roleFilter', function ($query) {
            $user = Auth::user();

            if (!$user) return;

            if (getRoleName() == config('enum.salesman') || getRoleName() == config('enum.admin')) {
                return $query->where('createdby_id', $user->id);
            }
        });
    }

    public function MetalPurchaseOrderDetail()
    {
        return $this->hasMany(MetalPurchaseOrderDetail::class, 'metal_purchase_order_id');
    }

    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function metal_sale_order()
    {
        return $this->belongsTo(MetalSaleOrder::class, 'metal_sale_order_id');
    }

    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approvedby_id');
    }
}
