<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondPurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'diamond_purchase_id',
        'diamond_type_id',
        'diamond_cut_id',
        'diamond_color_id',
        'diamond_clarity_id',
        'carat',
        'carat_price',
        'qty',
        'total_amount',
        'total_dollar', 
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

    public function created_by()
    {
        return $this->belongsTo(User::class, 'createdby_id');
    }
}
