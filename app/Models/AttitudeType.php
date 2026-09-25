<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class AttitudeType extends Model
{
    use LogsActivity;

    protected $fillable = [
        'wave_program_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function waveProgram()
    {
        return $this->belongsTo(WaveProgram::class);
    }

    public function scores()
    {
        return $this->hasMany(
            AttitudeScore::class,
            'attitude_type_id'
        );
    }
}
