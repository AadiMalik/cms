<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SupplierPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'supplier_id',
        'account_id',
        'payment_date',
        'cheque_ref',
        'tax',
        'tax_amount',
        'tax_account_id',
        'sub_total',
        'currency',
        'is_consumed',
        'other_product_id',
        'warehouse_id',
        'total',
        'jv_id',
        'created_at',
        'updated_at',
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

            if (!$user) return $query;

            if (in_array($user->role, [config('enum.salesman'), config('enum.admin')])) {
                return $query->where('createdby_id', $user->id);
            } else {
                return $query;
            }

            return $query;
        });
    }

    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function account_name()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function tax_account_name()
    {
        return $this->belongsTo(Account::class, 'tax_account_id');
    }
    public function jv_name()
    {
        return $this->belongsTo(JournalEntry::class, 'jv_id');
    }

    public function other_product()
    {
        return $this->belongsTo(OtherProduct::class, 'other_product_id');
    }
    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
