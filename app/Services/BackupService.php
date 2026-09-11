<?php

namespace App\Services;

use App\Models\Backup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class BackupService
{
    /**
     * Membuat backup database.
     */
    public function createDatabaseBackup(
        ?int $userId = null
    ): Backup {

        $backup = Backup::create([
            'user_id' => $userId,

            'name' =>
            'Database Backup ' .
                now()->format('Y-m-d H:i:s'),

            'filename' => '',

            'disk' => 'local',

            'size' => 0,

            'type' => 'database',

            'status' => 'processing',

            'started_at' => now(),
        ]);


        try {

            /*
            |--------------------------------------------------------------------------
            | Folder backup
            |--------------------------------------------------------------------------
            */

            $backupDirectory =
                storage_path('app/backups');


            if (!File::exists($backupDirectory)) {

                File::makeDirectory(
                    $backupDirectory,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Nama file
            |--------------------------------------------------------------------------
            */

            $filename =
                'MGS_DATABASE_' .
                now()->format('Y-m-d_H-i-s') .
                '.sql';


            $path =
                $backupDirectory .
                DIRECTORY_SEPARATOR .
                $filename;


            /*
            |--------------------------------------------------------------------------
            | Dump database
            |--------------------------------------------------------------------------
            */

            $this->dumpDatabase(
                $path
            );


            /*
            |--------------------------------------------------------------------------
            | Validasi file
            |--------------------------------------------------------------------------
            */

            if (!File::exists($path)) {

                throw new RuntimeException(
                    'File backup database tidak berhasil dibuat.'
                );
            }


            $size =
                File::size($path);


            if ($size <= 0) {

                throw new RuntimeException(
                    'File backup database kosong.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan informasi backup
            |--------------------------------------------------------------------------
            */

            $backup->update([

                'filename' =>
                'backups/' . $filename,

                'size' =>
                $size,

                'status' =>
                'completed',

                'completed_at' =>
                now(),
            ]);


            return $backup;
        } catch (\Throwable $e) {

            $backup->update([

                'status' =>
                'failed',

                'error_message' =>
                $e->getMessage(),

                'completed_at' =>
                now(),
            ]);


            throw $e;
        }
    }


    /**
     * Dump database menggunakan mysqldump.
     */
    /**
     * Dump database menggunakan mysqldump.
     */
    protected function dumpDatabase(string $outputPath): void
    {
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        if (!$database) {
            throw new RuntimeException(
                'Nama database tidak ditemukan.'
            );
        }

        $mysqldump = $this->findMysqldump();

        $command =
            escapeshellarg($mysqldump) .
            ' --host=' . escapeshellarg($host) .
            ' --port=' . escapeshellarg($port) .
            ' --user=' . escapeshellarg($username);

        if ($password !== null && $password !== '') {
            $command .=
                ' --password=' . escapeshellarg($password);
        }

        /*
    |--------------------------------------------------------------------------
    | Jangan backup tabel backups
    |--------------------------------------------------------------------------
    |
    | Tabel ini berisi riwayat backup sistem.
    | Jika ikut dibackup, status "processing" dari backup
    | yang sedang dibuat dapat ikut tersimpan dan muncul
    | kembali setelah restore.
    |
    */

        $command .=
            ' --ignore-table=' .
            escapeshellarg($database . '.backups');

        /*
    |--------------------------------------------------------------------------
    | Database tujuan
    |--------------------------------------------------------------------------
    */

        $command .=
            ' ' . escapeshellarg($database) .
            ' > ' . escapeshellarg($outputPath) .
            ' 2>&1';

        exec(
            $command,
            $output,
            $returnCode
        );

        if ($returnCode !== 0) {

            $message = trim(
                implode(PHP_EOL, $output)
            );

            throw new RuntimeException(
                'Gagal membuat database backup.' .
                    ($message ? ' ' . $message : '')
            );
        }
    }


    /**
     * Mencari executable mysqldump.
     */
    protected function findMysqldump(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Path dari .env
        |--------------------------------------------------------------------------
        */

        $configuredPath =
            env('MYSQLDUMP_PATH');


        if ($configuredPath) {
            return $configuredPath;
        }


        /*
        |--------------------------------------------------------------------------
        | XAMPP Windows
        |--------------------------------------------------------------------------
        */

        $xamppPath =
            'C:\\xampp\\mysql\\bin\\mysqldump.exe';


        if (File::exists($xamppPath)) {
            return $xamppPath;
        }


        /*
        |--------------------------------------------------------------------------
        | Linux
        |--------------------------------------------------------------------------
        */

        $linuxPath =
            '/usr/bin/mysqldump';


        if (File::exists($linuxPath)) {
            return $linuxPath;
        }


        return 'mysqldump';
    }


    /**
     * Mendapatkan path fisik backup.
     */
    public function getBackupPath(
        Backup $backup
    ): string {

        if ($backup->type !== 'database') {

            throw new RuntimeException(
                'Backup bukan merupakan backup database.'
            );
        }


        $path =
            storage_path(
                'app/' .
                    $backup->filename
            );


        if (!File::exists($path)) {

            throw new RuntimeException(
                'File backup tidak ditemukan.'
            );
        }


        return $path;
    }


    /**
     * Restore database dari backup yang tersimpan.
     */
    public function restoreDatabase(
        Backup $backup
    ): void {

        $path =
            $this->getBackupPath(
                $backup
            );


        $this->restoreSqlFile(
            $path
        );
    }


    /**
     * Restore database dari file SQL yang diupload.
     */
    public function restoreUploadedBackup(
        UploadedFile $file,
        ?int $userId = null
    ): void {

        $extension =
            strtolower(
                $file->getClientOriginalExtension()
            );


        if ($extension !== 'sql') {

            throw new RuntimeException(
                'Format file tidak didukung. Gunakan file .sql.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Temporary directory
        |--------------------------------------------------------------------------
        */

        $tempDirectory =
            storage_path(
                'app/backup-restore-temp/' .
                    Str::uuid()
            );


        File::makeDirectory(
            $tempDirectory,
            0755,
            true
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | Nama file aman
            |--------------------------------------------------------------------------
            */

            $filename =
                'restore_' .
                Str::uuid() .
                '.sql';


            $uploadedPath =
                $tempDirectory .
                DIRECTORY_SEPARATOR .
                $filename;


            /*
            |--------------------------------------------------------------------------
            | Simpan upload
            |--------------------------------------------------------------------------
            */

            $file->move(
                $tempDirectory,
                $filename
            );


            /*
            |--------------------------------------------------------------------------
            | Restore database
            |--------------------------------------------------------------------------
            */

            $this->restoreSqlFile(
                $uploadedPath
            );
        } finally {

            /*
            |--------------------------------------------------------------------------
            | Hapus temporary
            |--------------------------------------------------------------------------
            */

            if (
                File::exists(
                    $tempDirectory
                )
            ) {

                File::deleteDirectory(
                    $tempDirectory
                );
            }
        }
    }


    /**
     * Restore database dari file SQL.
     */
    protected function restoreSqlFile(string $sqlPath): void
    {
        /*
    |--------------------------------------------------------------------------
    | Validasi file SQL
    |--------------------------------------------------------------------------
    */

        if (!File::exists($sqlPath)) {

            throw new RuntimeException(
                'File SQL tidak ditemukan.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Database configuration
    |--------------------------------------------------------------------------
    */

        $host =
            config(
                'database.connections.mysql.host',
                '127.0.0.1'
            );

        $port =
            config(
                'database.connections.mysql.port',
                3306
            );

        $database =
            config(
                'database.connections.mysql.database'
            );

        $username =
            config(
                'database.connections.mysql.username'
            );

        $password =
            config(
                'database.connections.mysql.password'
            );


        if (!$database) {

            throw new RuntimeException(
                'Nama database tidak ditemukan.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Cari mysql.exe
    |--------------------------------------------------------------------------
    */

        $mysql =
            $this->findMysql();


        if (
            !File::exists($mysql)
        ) {

            throw new RuntimeException(
                'mysql.exe tidak ditemukan. ' .
                    'Pastikan XAMPP/MySQL terpasang.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Command Restore
    |--------------------------------------------------------------------------
    |
    | Menggunakan metode yang sama dengan pengujian manual
    | di CMD Windows:
    |
    | mysql.exe -u root database < backup.sql
    |
    */

        $command =
            escapeshellarg($mysql) .
            ' --host=' .
            escapeshellarg($host) .
            ' --port=' .
            escapeshellarg($port) .
            ' --user=' .
            escapeshellarg($username);


        /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

        if (
            $password !== null &&
            $password !== ''
        ) {

            $command .=
                ' --password=' .
                escapeshellarg($password);
        }


        /*
    |--------------------------------------------------------------------------
    | Database + SQL file
    |--------------------------------------------------------------------------
    */

        $command .=
            ' ' .
            escapeshellarg($database) .
            ' < ' .
            escapeshellarg($sqlPath) .
            ' 2>&1';


        /*
    |--------------------------------------------------------------------------
    | Jalankan restore
    |--------------------------------------------------------------------------
    */

        exec(
            $command,
            $output,
            $returnCode
        );


        /*
    |--------------------------------------------------------------------------
    | Periksa hasil
    |--------------------------------------------------------------------------
    */

        if ($returnCode !== 0) {

            $message =
                trim(
                    implode(
                        PHP_EOL,
                        $output
                    )
                );


            throw new RuntimeException(
                'Gagal melakukan restore database.' .
                    (
                        $message
                        ? ' ' . $message
                        : ''
                    )
            );
        }
    }


    /**
     * Mencari executable mysql.
     */
    protected function findMysql(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Path dari .env
        |--------------------------------------------------------------------------
        */

        $configuredPath =
            env('MYSQL_PATH');


        if ($configuredPath) {
            return $configuredPath;
        }


        /*
        |--------------------------------------------------------------------------
        | XAMPP Windows
        |--------------------------------------------------------------------------
        */

        $xamppPath =
            'C:\\xampp\\mysql\\bin\\mysql.exe';


        if (File::exists($xamppPath)) {
            return $xamppPath;
        }


        /*
        |--------------------------------------------------------------------------
        | Linux
        |--------------------------------------------------------------------------
        */

        $linuxPath =
            '/usr/bin/mysql';


        if (File::exists($linuxPath)) {
            return $linuxPath;
        }


        return 'mysql';
    }
}
