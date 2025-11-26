<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MetalPurchase extends Model
{
    use HasFactory;

    protected $table = 'metal_purchases';

    protected $fillable = [
        'id',
        'metal_purchase_no',
        'purchase_date',
        'supplier_id',
        'purchase_account_id',
        'paid_account_id',
        'paid_account_dollar_id',
        'tax_account_id',
        'paid',
        'reference',
        'pictures',
        'tax_amount',
        'sub_total',
        'total',
        'total_dollar',
        'jv_id',
        'paid_jv_id',
        'paid_dollar_jv_id',
        'supplier_payment_id',
        'supplier_dollar_payment_id',
        'is_active',
        'is_posted',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
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
    public function MetalPurchaseDetail()
    {
        return $this->hasMany(MetalPurchaseDetail::class, 'metal_purchase_id');
    }
    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function supplier_payment()
    {
        return $this->belongsTo(SupplierPayment::class, 'supplier_payment_id');
    }

    public function purchase_account_name()
    {
        return $this->belongsTo(Account::class, 'purchase_account_id');
    }
    public function paid_account_name()
    {
        return $this->belongsTo(Account::class, 'paid_account_id');
    }
    public function paid_account_dollar_name()
    {
        return $this->belongsTo(Account::class, 'paid_account_dollar_id');
    }
    public function tax_account_name()
    {
        return $this->belongsTo(Account::class, 'tax_account_id');
    }
}
