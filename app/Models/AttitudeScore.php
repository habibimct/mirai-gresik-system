<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttitudeScore extends Model
{
    protected $fillable = [
        'attitude_session_id',
        'participant_classroom_id',
        'attitude_type_id',
        'score',
        'notes',
    ];

    public function session()
    {
        return $this->belongsTo(
            AttitudeSession::class,
            'attitude_session_id'
        );
    }

    public function participantClassroom()
    {
        return $this->belongsTo(
            ParticipantClassroom::class
        );
    }

    public function type()
    {
        return $this->belongsTo(
            AttitudeType::class,
            'attitude_type_id'
        );
    }
}