<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'attendance_session_id',
        'participant_classroom_id',
        'status',
    ];

    public function session()
    {
        return $this->belongsTo(
            AttendanceSession::class,
            'attendance_session_id'
        );
    }

    public function participantClassroom()
    {
        return $this->belongsTo(
            ParticipantClassroom::class
        );
    }
}
