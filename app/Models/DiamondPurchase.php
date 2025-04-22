<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'diamond_purchase_no',
        'diamond_purchase_date',
        'bill_no',
        'supplier_id',
        'warehouse_id',
        'reference',
        'total_qty',
        'tax',
        'tax_amount',
        'sub_total',
        'total',
        'total_dollar',
        'is_pkr',
        'paid',
        'purchase_account_id',
        'paid_account_id',
        'supplier_payment_id',
        'jv_id',
        'paid_jv_id',
        'posted',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];

    
    public function DiamondPurchaseDetail()
    {
        return $this->hasMany(DiamondPurchaseDetail::class, 'diamond_purchase_id');
    }
    public function jv()
    {
        return $this->belongsTo(JournalEntry::class, 'jv_id');
    }
    public function paid_jv()
    {
        return $this->belongsTo(JournalEntry::class, 'paid_jv_id');
    }
    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function purchase_account()
    {
        return $this->belongsTo(Account::class, 'purchase_account_id');
    }
    public function paid_account()
    {
        return $this->belongsTo(Account::class, 'paid_account_id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
