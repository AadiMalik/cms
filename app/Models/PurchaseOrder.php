<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'purchase_order_no',
        'purchase_order_date',
        'supplier_id',
        'warehouse_id',
        'total_qty',
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

    public function PurchaseOrderDetail()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }

    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function sale_order()
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_id');
    }

    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
