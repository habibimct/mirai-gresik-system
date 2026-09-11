<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        |
        | Format:
        | modul.action
        |
        */

        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */

            'dashboard.view',


            /*
            |--------------------------------------------------------------------------
            | PESERTA
            |--------------------------------------------------------------------------
            */

            'participants.view',
            'participants.create',
            'participants.edit',
            'participants.delete',


            /*
            |--------------------------------------------------------------------------
            | INSTRUKTUR
            |--------------------------------------------------------------------------
            */

            'instructors.view',
            'instructors.create',
            'instructors.edit',
            'instructors.delete',


            /*
            |--------------------------------------------------------------------------
            | PROGRAM
            |--------------------------------------------------------------------------
            */

            'programs.view',
            'programs.create',
            'programs.edit',
            'programs.delete',


            /*
            |--------------------------------------------------------------------------
            | GELOMBANG
            |--------------------------------------------------------------------------
            */

            'waves.view',
            'waves.create',
            'waves.edit',
            'waves.delete',


            /*
            |--------------------------------------------------------------------------
            | KELAS
            |--------------------------------------------------------------------------
            */

            'classrooms.view',
            'classrooms.create',
            'classrooms.edit',
            'classrooms.delete',


            /*
            |--------------------------------------------------------------------------
            | JADWAL
            |--------------------------------------------------------------------------
            */

            'schedules.view',
            'schedules.create',
            'schedules.edit',
            'schedules.delete',


            /*
            |--------------------------------------------------------------------------
            | WAVE PROGRAM
            |--------------------------------------------------------------------------
            */

            'wave_programs.view',
            'wave_programs.create',
            'wave_programs.edit',
            'wave_programs.delete',


            /*
            |--------------------------------------------------------------------------
            | PESERTA - WAVE PROGRAM
            |--------------------------------------------------------------------------
            */

            'participant_wave_programs.view',
            'participant_wave_programs.create',
            'participant_wave_programs.edit',
            'participant_wave_programs.delete',


            /*
            |--------------------------------------------------------------------------
            | REKAP NILAI
            |--------------------------------------------------------------------------
            */

            'score_recaps.view',
            'score_recaps.create',
            'score_recaps.edit',
            'score_recaps.delete',


            /*
            |--------------------------------------------------------------------------
            | KEUANGAN - PENGATURAN BIAYA
            |--------------------------------------------------------------------------
            */

            'fee_settings.view',
            'fee_settings.create',
            'fee_settings.edit',
            'fee_settings.delete',


            /*
            |--------------------------------------------------------------------------
            | KEUANGAN - TAGIHAN PESERTA
            |--------------------------------------------------------------------------
            */

            'participant_invoices.view',
            'participant_invoices.create',
            'participant_invoices.edit',
            'participant_invoices.delete',


            /*
            |--------------------------------------------------------------------------
            | LAPORAN PESERTA
            |--------------------------------------------------------------------------
            */

            'reports.participants.view',
            'reports.participants.export',


            /*
            |--------------------------------------------------------------------------
            | LAPORAN AKADEMIK
            |--------------------------------------------------------------------------
            */

            'reports.academics.view',
            'reports.academics.export',


            /*
            |--------------------------------------------------------------------------
            | LAPORAN KEUANGAN
            |--------------------------------------------------------------------------
            */

            'reports.finances.view',
            'reports.finances.export',


            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',


            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */

            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',


            /*
            |--------------------------------------------------------------------------
            | PERMISSION
            |--------------------------------------------------------------------------
            */

            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',


            /*
            |--------------------------------------------------------------------------
            | PENGURUS
            |--------------------------------------------------------------------------
            */

            'pengurus.view',
            'pengurus.create',
            'pengurus.edit',
            'pengurus.delete',

        ];


        /*
        |--------------------------------------------------------------------------
        | Create Permission
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {

            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ]
            );

        }
    }
}