<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ScoreSession extends Model
{
    use LogsActivity;
    protected $fillable = [
        'classroom_id',
        'week',
        'assessment_date',
        'title',
        'is_active',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function sessionTypes()
    {
        return $this->hasMany(ScoreSessionType::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}