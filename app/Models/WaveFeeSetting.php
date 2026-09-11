<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class WaveFeeSetting extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'wave_id',
        'fee_name',
        'amount',
    ];

    public function wave()
    {
        return $this->belongsTo(Wave::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(
            ParticipantInvoiceItem::class,
            'fee_name',
            'fee_name'
        );
    }
}
