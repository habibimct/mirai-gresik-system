<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reset Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            'Super Admin',
            'Admin',
            'Staff Administrasi',
            'Bendahara',
            'Instruktur',
            'Pengurus',
            'Peserta',
        ];


        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        foreach ($roles as $roleName) {

            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | Super Admin mendapatkan seluruh permission.
        |
        */

        $superAdmin = Role::findByName('Super Admin', 'web');

        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName('Admin', 'web');

        $adminPermissions = [

            'dashboard.view',

            // Peserta
            'participants.view',
            'participants.create',
            'participants.edit',
            'participants.delete',

            // Instruktur
            'instructors.view',
            'instructors.create',
            'instructors.edit',
            'instructors.delete',

            // Program
            'programs.view',
            'programs.create',
            'programs.edit',
            'programs.delete',

            // Gelombang
            'waves.view',
            'waves.create',
            'waves.edit',
            'waves.delete',

            // Kelas
            'classrooms.view',
            'classrooms.create',
            'classrooms.edit',
            'classrooms.delete',

            // Jadwal
            'schedules.view',
            'schedules.create',
            'schedules.edit',
            'schedules.delete',

            // Wave Program
            'wave_programs.view',
            'wave_programs.create',
            'wave_programs.edit',
            'wave_programs.delete',

            // Peserta Wave Program
            'participant_wave_programs.view',
            'participant_wave_programs.create',
            'participant_wave_programs.edit',
            'participant_wave_programs.delete',

            // Rekap Nilai
            'score_recaps.view',
            'score_recaps.create',
            'score_recaps.edit',
            'score_recaps.delete',

            // Keuangan
            'fee_settings.view',
            'fee_settings.create',
            'fee_settings.edit',
            'fee_settings.delete',

            'participant_invoices.view',
            'participant_invoices.create',
            'participant_invoices.edit',
            'participant_invoices.delete',

            // Laporan
            'reports.participants.view',
            'reports.participants.export',

            'reports.academics.view',
            'reports.academics.export',

            'reports.finances.view',
            'reports.finances.export',

            // User
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Role
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];

        $admin->syncPermissions($adminPermissions);


        /*
        |--------------------------------------------------------------------------
        | STAFF ADMINISTRASI
        |--------------------------------------------------------------------------
        */

        $staff = Role::findByName('Staff Administrasi', 'web');

        $staffPermissions = [

            'dashboard.view',

            'participants.view',
            'participants.create',
            'participants.edit',

            'instructors.view',
            'instructors.create',
            'instructors.edit',

            'programs.view',
            'programs.create',
            'programs.edit',

            'waves.view',
            'waves.create',
            'waves.edit',

            'classrooms.view',
            'classrooms.create',
            'classrooms.edit',

            'schedules.view',
            'schedules.create',
            'schedules.edit',

            'wave_programs.view',
            'wave_programs.create',
            'wave_programs.edit',

            'participant_wave_programs.view',
            'participant_wave_programs.create',
            'participant_wave_programs.edit',

            'score_recaps.view',

            'reports.participants.view',
            'reports.participants.export',

            'reports.academics.view',
            'reports.academics.export',

        ];

        $staff->syncPermissions($staffPermissions);


        /*
        |--------------------------------------------------------------------------
        | BENDAHARA
        |--------------------------------------------------------------------------
        */

        $bendahara = Role::findByName('Bendahara', 'web');

        $bendaharaPermissions = [

            'dashboard.view',

            // Keuangan
            'fee_settings.view',
            'fee_settings.create',
            'fee_settings.edit',

            'participant_invoices.view',
            'participant_invoices.create',
            'participant_invoices.edit',

            // Data Peserta
            'participants.view',

            // Laporan
            'reports.participants.view',
            'reports.finances.view',
            'reports.finances.export',

        ];

        $bendahara->syncPermissions($bendaharaPermissions);


        /*
        |--------------------------------------------------------------------------
        | INSTRUKTUR
        |--------------------------------------------------------------------------
        */

        $instruktur = Role::findByName('Instruktur', 'web');

        $instrukturPermissions = [

            'dashboard.view',

            'participants.view',

            'classrooms.view',

            'schedules.view',

            'score_recaps.view',
            'score_recaps.create',
            'score_recaps.edit',

            'programs.view',

        ];

        $instruktur->syncPermissions($instrukturPermissions);


        /*
        |--------------------------------------------------------------------------
        | PENGURUS
        |--------------------------------------------------------------------------
        */

        $pengurus = Role::findByName('Pengurus', 'web');

        $pengurusPermissions = [

            'dashboard.view',

            'participants.view',

            'instructors.view',

            'programs.view',

            'waves.view',

            'classrooms.view',

            'schedules.view',

            'wave_programs.view',

            'participant_wave_programs.view',

            'score_recaps.view',

            'reports.participants.view',
            'reports.academics.view',
            'reports.finances.view',

        ];

        $pengurus->syncPermissions($pengurusPermissions);


        /*
        |--------------------------------------------------------------------------
        | PESERTA
        |--------------------------------------------------------------------------
        */

        $peserta = Role::findByName('Peserta', 'web');

        $pesertaPermissions = [

            'dashboard.view',

            'participants.view',

            'programs.view',

            'classrooms.view',

            'schedules.view',

        ];

        $peserta->syncPermissions($pesertaPermissions);


        /*
        |--------------------------------------------------------------------------
        | Reset Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}