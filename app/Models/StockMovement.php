<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id','type','ref_type','ref_id',
        'qty_in','qty_out','balance_after','notes','created_by'
    ];

    public function product(){ return $this->belongsTo(Product::class); }
    public function user(){ return $this->belongsTo(User::class, 'created_by'); }
}
