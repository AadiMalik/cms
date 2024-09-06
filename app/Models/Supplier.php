<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','name','contact','cnic','company','type','account_id','is_active','is_deleted','createdby_id','updatedby_id',
        'deletedby_id'
    ];

    public function account_name()
    {
        return $this->belongsTo(Account::class,'account_id');
    }
}
