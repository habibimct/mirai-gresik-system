<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ParticipantClassroom;
use App\Models\ScoreSession;
use App\Traits\LogsActivity;

class Classroom extends Model
{
    use LogsActivity;
    protected $fillable = [

        'wave_program_id',

        'code',

        'name',

        'capacity',

        'minimum_score',

        'minimum_attendance',

        'room',

        'description',

        'is_active',

    ];

    public function waveProgram()
    {
        return $this->belongsTo(WaveProgram::class);
    }

    public function participantClassrooms()
    {
        return $this->hasMany(ParticipantClassroom::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class)
            ->orderByRaw("
            CASE day
                WHEN 'Senin' THEN 1
                WHEN 'Selasa' THEN 2
                WHEN 'Rabu' THEN 3
                WHEN 'Kamis' THEN 4
                WHEN 'Jumat' THEN 5
                WHEN 'Sabtu' THEN 6
            END
        ")
            ->orderBy('start_time');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function scoreSessions()
    {
        return $this->hasMany(ScoreSession::class);
    }

    public function attitudeSessions()
    {
        return $this->hasMany(AttitudeSession::class);
    }
}
