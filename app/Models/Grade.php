<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'participant_classroom_id',
        'subject',
        'score',
        'note',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function participantClassroom()
    {
        return $this->belongsTo(
            ParticipantClassroom::class
        );
    }
}