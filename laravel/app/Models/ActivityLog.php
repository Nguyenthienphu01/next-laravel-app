<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'module',
        'action', 
        'user_id',
        'target_id',
        'target_type',
        'description',
        'changes'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}