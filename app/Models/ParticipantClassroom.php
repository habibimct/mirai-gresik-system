<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ParticipantClassroom extends Model
{
    use LogsActivity;
    protected $fillable = [

        'participant_wave_program_id',

        'classroom_id',

        'joined_at',

        'status',

    ];

    protected $casts = [

        'joined_at' => 'date',

    ];

    public function participantWaveProgram()
    {
        return $this->belongsTo(
            ParticipantWaveProgram::class
        );
    }

    public function classroom()
    {
        return $this->belongsTo(
            Classroom::class
        );
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function invoice()
    {
        return $this->hasOne(
            ParticipantInvoice::class
        );
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
