<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Payment extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'participant_invoice_id',
        'payment_date',
        'payment_type',
        'payment_channel',
        'amount',
        'reference_number',
        'note',
        'received_by',
    ];

    public function invoice()
    {
        return $this->belongsTo(
            ParticipantInvoice::class,
            'participant_invoice_id'
        );
    }

    public function receiver()
    {
        return $this->belongsTo(
            User::class,
            'received_by'
        );
    }
}
