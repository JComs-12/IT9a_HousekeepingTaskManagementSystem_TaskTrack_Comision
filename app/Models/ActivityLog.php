<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'action',
        'description',
        'is_important',
        'subject_type',
        'subject_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}