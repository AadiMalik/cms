<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Retainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'day_of_month',
        'journal_id',
        'debit_account_id',
        'credit_account_id',
        'currency',
        'amount',
        'status',
        'confirmed_by',
        'is_active',
        'notification_at',
        'confirmed_at',
        'jv_id',
        'createdby_id',
        'updatedby_id',
        'created_at',
        'updated_at',
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
    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function debit_account()
    {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function credit_account()
    {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }

    public function jv()
    {
        return $this->belongsTo(JournalEntry::class, 'jv_id');
    }
}
