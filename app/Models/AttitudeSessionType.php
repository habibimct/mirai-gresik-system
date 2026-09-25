<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class AttitudeSessionType extends Model
{
    use LogsActivity;

    protected $fillable = [
        'attitude_session_id',
        'attitude_type_id',
    ];

    public function session()
    {
        return $this->belongsTo(
            AttitudeSession::class,
            'attitude_session_id'
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