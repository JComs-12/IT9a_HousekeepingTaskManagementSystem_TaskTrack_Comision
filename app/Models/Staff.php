<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'birthdate',
        'age',
        'gender',
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