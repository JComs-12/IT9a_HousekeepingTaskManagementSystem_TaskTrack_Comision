<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'birthdate',
        'age',
        'status',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_staff');
    }
}