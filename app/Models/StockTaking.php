<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockTaking extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'stock_date',
        'warehouse_id',
        'is_opening_stock',
        'posted',
        'is_deleted',
        'createdby_id',
        'updatedby_id',
        'deletedby_id',
        'created_at',
        'updated_at',

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
    public function StockTakingDetail()
    {
        return $this->belongsToMany(StockTakingDetail::class);
    }
    public function warehouse_name()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }


    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
