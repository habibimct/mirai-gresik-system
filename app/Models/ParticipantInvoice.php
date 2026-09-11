<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_classroom_id',
        'total_amount',
        'paid_amount',
        'status',
        'is_final',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'is_final' => 'boolean',
    ];

    public function participantClassroom()
    {
        return $this->belongsTo(ParticipantClassroom::class);
    }

    public function items()
    {
        return $this->hasMany(ParticipantInvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
