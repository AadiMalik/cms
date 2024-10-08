<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','name','email','phone','address','is_deleted','createdby_id','updatedby_id',
        'deletedby_id'
    ];
}
