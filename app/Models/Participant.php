<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Participant extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [

        'user_id',

        'program_id',

        'wave_id',

        'nik',

        'gender',

        'birth_place',

        'birth_date',

        'address',

        'education',

        'job',

        'status',

    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function wavePrograms()
    {
        return $this->belongsToMany(
            WaveProgram::class,
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

    public function participantClassrooms()
    {
        return $this->hasManyThrough(
            ParticipantClassroom::class,
            ParticipantWaveProgram::class,
            'participant_id',
            'participant_wave_program_id',
            'id',
            'id'
        );
    }
}
