<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'score_session_id',
        'participant_classroom_id',
        'score_type_id',
        'score',
        'notes',
    ];

    public function session()
    {
        return $this->belongsTo(ScoreSession::class, 'score_session_id');
    }

    public function participantClassroom()
    {
        return $this->belongsTo(ParticipantClassroom::class);
    }

    public function type()
    {
        return $this->belongsTo(ScoreType::class, 'score_type_id');
    }
    
}