<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'room_id',
        'task_name',
        'description',
        'priority',
        'due_date',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'task_staff');
    }
}