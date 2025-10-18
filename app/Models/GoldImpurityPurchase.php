<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GoldImpurityPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'gold_impurity_purchase_no',
        'customer_id',
        'total_qty',
        'total_weight',
        'total',
        'cash_payment',
        'bank_payment',
        'total_payment',
        'balance',
        'jv_id',
        'cash_jv_id',
        'bank_jv_id',
        'is_posted',
        'is_mix_stock',
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

    public function GoldImpurityPurchaseDetail()
    {
        return $this->hasMany(GoldImpurityPurchaseDetail::class, 'gold_impurity_purchase_id');
    }

    public function customer_name()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
