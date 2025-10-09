<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
