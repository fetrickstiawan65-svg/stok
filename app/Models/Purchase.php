<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_no','supplier_id','date',
        'subtotal','discount_total','grand_total',
        'status','created_by'
    ];

    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function items(){ return $this->hasMany(PurchaseItem::class); }
    public function user(){ return $this->belongsTo(User::class, 'created_by'); }
}
