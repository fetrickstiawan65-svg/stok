<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name','address','phone',
        'tax_enabled','tax_percent',
        'rounding_enabled','rounding_mode','rounding_to'
    ];
}
