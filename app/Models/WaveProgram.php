<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaveProgram extends Model
{
    protected $fillable = [

        'wave_id',

        'program_id',

        'fee',

        'quota',

        'is_active',

    ];

    public function wave()
    {
        return $this->belongsTo(Wave::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function participants()
    {
        return $this->belongsToMany(
            Participant::class,
            'participant_wave_programs'
        )->withPivot([
            'agreed_fee',
            'discount',
            'status',
            'notes'
        ]);
    }

    public function participantWavePrograms()
    {
        return $this->hasMany(ParticipantWaveProgram::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
