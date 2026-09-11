<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WaveProgram;
use App\Traits\LogsActivity;

class ScoreType extends Model
{
    use LogsActivity;
    protected $fillable = [
        'wave_program_id',
        'name',
        'is_active',
    ];

    public function scoreSessionTypes()
    {
        return $this->hasMany(ScoreSessionType::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function waveProgram()
    {
        return $this->belongsTo(WaveProgram::class);
    }
}
