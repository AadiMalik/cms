<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RattiKaat extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ratti_kaat_no',
        'purchase_date',
        'supplier_id',
        'purchase_account',
        'purchase_order_id',
        'paid',
        'paid_account',
        'paid_au',
        'paid_account_au',
        'paid_dollar',
        'paid_account_dollar',
        'reference',
        'pictures',
        'tax_amount',
        'tax_account',
        'sub_total',
        'total',
        'total_au',
        'total_dollar',
        'jv_id',
        'paid_jv_id',
        'paid_au_jv_id',
        'paid_dollar_jv_id',
        'supplier_payment_id',
        'supplier_au_payment_id',
        'supplier_dollar_payment_id',
        'is_active',
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

    public function RattiKaatDetail()
    {
        return $this->hasMany(RattiKaatDetail::class, 'ratti_kaat_id');
    }
    public function purchase_account_name()
    {
        return $this->belongsTo(Account::class, 'purchase_account');
    }
    public function purchase_order_name()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function paid_account_name()
    {
        return $this->belongsTo(Account::class, 'paid_account');
    }
    public function paid_au_account_name()
    {
        return $this->belongsTo(Account::class, 'paid_au_account');
    }
    public function paid_dollar_account_name()
    {
        return $this->belongsTo(Account::class, 'paid_dollar_account');
    }
    public function tax_account_name()
    {
        return $this->belongsTo(Account::class, 'tax_account');
    }
}
