<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function __construct(
        protected BackupService $backupService
    ) {}


    /**
     * Daftar backup.
     */
    public function index()
    {
        $backups = Backup::with('user')
            ->latest()
            ->paginate(15);

        return view('backup.index', compact(
            'backups'
        ));
    }


    /**
     * Membuat backup database.
     */
    public function store(Request $request)
    {
        try {

            $backup =
                $this->backupService
                ->createDatabaseBackup(
                    auth()->id()
                );


            return back()->with(
                'success',
                'Backup database berhasil dibuat: ' .
                    $backup->name
            );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Backup database gagal dibuat: ' .
                    $e->getMessage()
            );
        }
    }


    /**
     * Download backup database.
     */
    public function download(Backup $backup)
    {
        if ($backup->type !== 'database') {

            return back()->with(
                'error',
                'Jenis backup tidak valid.'
            );
        }


        if ($backup->status !== 'completed') {

            return back()->with(
                'error',
                'Backup belum selesai atau mengalami kegagalan.'
            );
        }


        try {

            $path =
                $this->backupService
                ->getBackupPath($backup);


            return response()->download(
                $path,
                basename($path)
            );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'File backup tidak dapat didownload: ' .
                    $e->getMessage()
            );
        }
    }


    /**
     * Restore dari riwayat backup.
     */
    public function restore(
        Request $request,
        Backup $backup
    ) {
        $request->validate([
            'confirmation' => [
                'required',
                'in:RESTORE MGS',
            ],
        ]);


        if ($backup->type !== 'database') {

            return back()->with(
                'error',
                'Hanya backup database yang dapat direstore.'
            );
        }


        if ($backup->status !== 'completed') {

            return back()->with(
                'error',
                'Backup yang gagal atau belum selesai tidak dapat direstore.'
            );
        }


        try {

            $this->backupService
                ->restoreDatabase($backup);


            return back()->with(
                'success',
                'Restore database berhasil dilakukan menggunakan backup: ' .
                    $backup->name
            );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Restore database gagal: ' .
                    $e->getMessage()
            );
        }
    }


    /**
     * Restore database dari file SQL yang diupload.
     */
    public function restoreUpload(Request $request)
    {
        $request->validate([
            'backup_file' => [
                'required',
                'file',
                'max:512000',
                'extensions:sql',
            ],

            'confirmation' => [
                'required',
                'in:RESTORE MGS',
            ],
        ]);

        try {

            $file = $request->file('backup_file');

            $this->backupService
                ->restoreUploadedBackup(
                    $file,
                    auth()->id()
                );

            return back()->with(
                'success',
                'Restore database berhasil dilakukan dari file: ' .
                    $file->getClientOriginalName()
            );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Restore database gagal: ' .
                    $e->getMessage()
            );
        }
    }


    /**
     * Hapus backup.
     */
    public function destroy(Backup $backup)
    {
        try {

            $path =
                storage_path(
                    'app/' . $backup->filename
                );


            if (File::exists($path)) {
                File::delete($path);
            }


            $backup->delete();


            return back()->with(
                'success',
                'Backup berhasil dihapus.'
            );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Backup gagal dihapus: ' .
                    $e->getMessage()
            );
        }
    }
}
