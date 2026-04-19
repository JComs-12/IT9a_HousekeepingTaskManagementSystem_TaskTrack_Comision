<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_staff');
    }
}