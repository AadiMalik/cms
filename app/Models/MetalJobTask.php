<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MetalJobTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'metal_job_task_no',
        'metal_job_task_date',
        'delivery_date',
        'metal_purchase_order_id',
        'metal_sale_order_id',
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

    public function MetalJobTaskDetail()
    {
        return $this->hasMany(MetalJobTaskDetail::class, 'metal_job_task_id');
    }

    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function metal_purchase_order()
    {
        return $this->belongsTo(MetalPurchaseOrder::class, 'metal_purchase_order_id');
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
}
