<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['action','entity','entity_id','meta_json','user_id'];

    protected $casts = [
        'meta_json' => 'array',
    ];

    public function user(){ return $this->belongsTo(User::class); }
}
