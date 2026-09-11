<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Wave extends Model
{
    use LogsActivity;
    protected $fillable = [

        'code',

        'name',

        'year',

        'registration_start',

        'registration_end',

        'training_start',

        'training_end',

        'is_active',

        'description',

    ];

    public function wavePrograms()
    {
        return $this->hasMany(WaveProgram::class);
    }

    public function programs()
    {
        return $this->belongsToMany(
            Program::class,
            'wave_programs'
        )->withPivot([
            'fee',
            'quota',
            'is_active'
        ]);
    }

    public function programFeeSettings()
    {
        return $this->hasMany(FeeSetting::class);
    }

    public function waveFeeSettings()
    {
        return $this->hasMany(WaveFeeSetting::class);
    }
}
