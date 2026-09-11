<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Backup extends Model
{
    protected $fillable = [

        'user_id',

        'name',

        'filename',

        'disk',

        'size',

        'type',

        'status',

        'description',

        'error_message',

        'started_at',

        'completed_at',

    ];


    protected $casts = [

        'started_at' => 'datetime',

        'completed_at' => 'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Ukuran File
    |--------------------------------------------------------------------------
    */

    public function getFormattedSizeAttribute(): string
    {
        $size = $this->size;

        if ($size >= 1024 * 1024 * 1024) {
            return number_format(
                $size / (1024 * 1024 * 1024),
                2
            ) . ' GB';
        }

        if ($size >= 1024 * 1024) {
            return number_format(
                $size / (1024 * 1024),
                2
            ) . ' MB';
        }

        if ($size >= 1024) {
            return number_format(
                $size / 1024,
                2
            ) . ' KB';
        }

        return $size . ' B';
    }
}