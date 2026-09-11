<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Program extends Model
{
    use LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    public function wavePrograms()
    {
        return $this->hasMany(WaveProgram::class);
    }

    public function waves()
    {
        return $this->belongsToMany(
            Wave::class,
            'wave_programs'
        )->withPivot([
            'fee',
            'quota',
            'is_active'
        ]);
    }

    public function feeSettings()
    {
        return $this->hasMany(FeeSetting::class);
    }
}
