<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RattiKaat extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ratti_kaat_no',
        'purchase_date',
        'supplier_id',
        'purchase_account',
        'paid',
        'paid_account',
        'reference',
        'pictures',
        'tax_amount',
        'tax_account',
        'sub_total',
        'total',
        'jv_id',
        'paid_jv_id',
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
    public function RattiKaatDetail()
    {
        return $this->hasMany(RattiKaatDetail::class, 'ratti_kaat_id');
    }
    public function purchase_account_name()
    {
        return $this->belongsTo(Account::class, 'purchase_account');
    }
    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function paid_account_name()
    {
        return $this->belongsTo(Account::class, 'paid_account');
    }
    public function tax_account_name()
    {
        return $this->belongsTo(Account::class, 'tax_account');
    }
}
