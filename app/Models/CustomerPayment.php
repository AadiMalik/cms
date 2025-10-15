<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'customer_id',
        'account_id',
        'payment_date',
        'reference',
        'tax',
        'tax_amount',
        'tax_account_id',
        'sub_total',
        'convert_amount',
        'currency',
        'convert_currency',
        'is_used',
        'type',
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

            if (!$user) return;

            if (getRoleName() == config('enum.salesman') || getRoleName() == config('enum.admin')) {
                return $query->where('createdby_id', $user->id);
            }
        });
    }

    public function customer_name()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
}
