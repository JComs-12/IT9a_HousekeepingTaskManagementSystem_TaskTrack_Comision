<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffReport extends Model
{
    protected $fillable = [
        'staff_id',
        'room_id',
        'report_type',
        'description',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}

