<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class FeeSetting extends Model
{
    use LogsActivity;
    protected $fillable = [

        'program_id',

        'wave_id',

        'fee_name',

        'amount',

    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function wave()
    {
        return $this->belongsTo(Wave::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
