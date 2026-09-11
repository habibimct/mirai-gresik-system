<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Nama data yang ditampilkan pada activity log.
     */
    public function getActivityLogName(): string
    {
        $attributes = $this->getAttributes();

        $possibleFields = [
            'name',
            'nama',
            'title',
            'program_name',
            'wave_name',
            'invoice_number',
            'invoice_no',
            'payment_number',
            'payment_no',
            'code',
            'kode',
            'number',
            'nomor',
        ];

        foreach ($possibleFields as $field) {
            if (
                isset($attributes[$field]) &&
                $attributes[$field] !== ''
            ) {
                return (string) $attributes[$field];
            }
        }

        return class_basename($this) . ' #' . $this->getKey();
    }

    /**
     * Nama model dalam bahasa yang lebih mudah dibaca.
     */
    public function getActivityLogModelName(): string
    {
        $names = [
            'User' => 'User',
            'Participant' => 'Peserta',
            'Classroom' => 'Classroom',
            'ParticipantClassroom' => 'Peserta Classroom',
            'Program' => 'Program',
            'Wave' => 'Gelombang',
            'FeeSetting' => 'Pengaturan Biaya',
            'WaveFeeSetting' => 'Pengaturan Biaya Gelombang',
            'ParticipantInvoice' => 'Invoice Peserta',
            'Payment' => 'Pembayaran',
            'AttendanceSession' => 'Sesi Absensi',
            'ScoreSession' => 'Sesi Nilai',
            'ScoreType' => 'Jenis Nilai',
        ];

        return $names[class_basename($this)]
            ?? Str::headline(class_basename($this));
    }
}