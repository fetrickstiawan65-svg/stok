<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_no','date',
        'subtotal','discount_total','tax_amount','grand_total',
        'payment_method','paid_amount','change_amount',
        'status','created_by'
    ];

    public function items(){ return $this->hasMany(SaleItem::class); }
    public function user(){ return $this->belongsTo(User::class, 'created_by'); }
}
