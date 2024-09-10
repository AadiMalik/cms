<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'contact',
        'email',
        'cnic',
        'address',
        'date_of_birth',
        'anniversary_date',
        'ring_size',
        'bangle_size',
        'account_id',
        'is_active',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];

    public function account_name()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
