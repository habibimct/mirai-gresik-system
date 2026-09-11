<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ScoreSessionType extends Model
{
    use LogsActivity;
    protected $fillable = [
        'score_session_id',
        'score_type_id',
    ];

    public function session()
    {
        return $this->belongsTo(ScoreSession::class, 'score_session_id');
    }

    public function type()
    {
        return $this->belongsTo(ScoreType::class, 'score_type_id');
    }
}