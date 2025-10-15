<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JournalEntry extends Model
{
    use HasFactory;
    protected $fillable = [
        'entryNum',
        'journal_id',
        'date_post',
        'reference',
        'status',
        'amount_in_words',
        'supplier_id',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
        'sale_order_id',
        'sale_id'
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

    public function journal_entry_detail()
    {
        return $this->hasMany(JournalEntryDetail::class, 'journal_entry_id');
    }
    public function journal_name()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
    public function sale_order_name()
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_id');
    }
    public function sale_name()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
    public function supplier_name()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function customer_name()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
