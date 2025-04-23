<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'date',
        'diamond_purchase_id',
        'diamond_sale_id',
        'diamond_type_id',
        'diamond_cut_id',
        'diamond_color_id',
        'diamond_clarity_id',
        'carat',
        'carat_price',
        'qty',
        'diamond_stock_taking_id',
        'diamond_stock_taking_link_id',
        'warehouse_id',
        'is_deleted',
        'createdby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'updated_at',
        'created_at'
    ];
    public function diamond_purchase()
    {
        return $this->belongsTo(DiamondPurchase::class, 'diamond_purchase_id');
    }

    public function diamond_sale()
    {
        return $this->belongsTo(DiamondPurchase::class, 'diamond_purchase_id');
    }

    public function diamond_type()
    {
        return $this->belongsTo(DiamondType::class, 'diamond_type_id');
    }

    public function diamond_cut()
    {
        return $this->belongsTo(DiamondCut::class, 'diamond_cut_id');
    }

    public function diamond_color()
    {
        return $this->belongsTo(DiamondColor::class, 'diamond_color_id');
    }
    public function diamond_clarity()
    {
        return $this->belongsTo(DiamondClarity::class, 'diamond_clarity_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
