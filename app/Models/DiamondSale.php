<?php

namespace App\Models;

use App\Http\Controllers\DiamondSaleController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'diamond_sale_no',
        'diamond_sale_date',
        'customer_id',
        'customer_name',
        'customer_cnic',
        'customer_contact',
        'customer_email',
        'customer_address',
        'warehouse_id',
        'total_qty',
        'tax',
        'tax_amount',
        'sub_total',
        'total',
        'total_dollar',
        'is_pkr',
        'is_credit',
        'cash_amount',
        'bank_transfer_amount',
        'card_amount',
        'advance_amount',
        'total_received',
        'jv_id',
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

    public function DiamondSaleDetail()
    {
        return $this->hasMany(DiamondSaleDetail::class, 'diamond_sale_id');
    }
    public function jv()
    {
        return $this->belongsTo(JournalEntry::class, 'jv_id');
    }
    public function customer_name()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
