<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ParticipantInvoiceItem extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'participant_invoice_id',
        'source',
        'fee_name',
        'amount',
        'is_required',
    ];

    public function invoice()
    {
        return $this->belongsTo(
            ParticipantInvoice::class,
            'participant_invoice_id'
        );
    }
}
