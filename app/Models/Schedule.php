<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Schedule extends Model
{
    use LogsActivity;

    protected $fillable = [

        'classroom_id',
        'instructor_id',
        'subject',
        'schedule_date',
        'day',
        'start_time',
        'end_time',
        'room',
        'description',
        'is_active',

    ];

    protected $casts = [

        'schedule_date' => 'date',

        'is_active' => 'boolean',

    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }
}