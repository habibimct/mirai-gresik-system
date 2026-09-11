<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Traits\LogsActivity;

class ParticipantWaveProgram extends Model
{
    use LogsActivity;
    protected $fillable = [

        'participant_id',

        'wave_program_id',

        'agreed_fee',

        'discount',

        'status',

        'notes',

    ];

    protected $casts = [
        'agreed_fee' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function waveProgram()
    {
        return $this->belongsTo(WaveProgram::class);
    }

    public function participantClassroom()
    {
        return $this->hasOne(ParticipantClassroom::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
