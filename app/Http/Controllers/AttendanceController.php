<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'status' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $classroom) {

            $schedule = Schedule::findOrFail($request->schedule_id);

            $session = AttendanceSession::create([

                'classroom_id' => $classroom->id,

                'schedule_id' => $schedule->id,

                // Tanggal absensi mengikuti tanggal jadwal
                'attendance_date' => $schedule->schedule_date,

            ]);

            foreach ($request->status as $participantClassroomId => $status) {

                Attendance::create([

                    'attendance_session_id' => $session->id,

                    'participant_classroom_id' => $participantClassroomId,

                    'status' => $status,

                ]);
            }
        });

        return back()->with(
            'success',
            'Absensi berhasil disimpan.'
        );
    }

    public function update(Request $request, Classroom $classroom, AttendanceSession $attendanceSession)
    {
        $request->validate(['schedule_id' => 'required|exists:schedules,id', 'status' => 'required|array',]);
        $schedule = Schedule::findOrFail($request->schedule_id);
        $attendanceSession->update(['schedule_id' => $schedule->id, 'attendance_date' => $schedule->schedule_date,]);
        foreach ($request->status as $attendanceId => $status) {
            Attendance::where('id', $attendanceId)->update(['status' => $status]);
        }
        return back()->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(
        Classroom $classroom,
        AttendanceSession $attendanceSession
    ) {
        // Pastikan attendance session memang milik kelas ini
        if ($attendanceSession->classroom_id != $classroom->id) {
            abort(404);
        }

        // Absensi tidak boleh dihapus setelah 12 jam
        if ($attendanceSession->created_at->diffInHours(now()) >= 12) {

            return back()->with(
                'error',
                'Absensi tidak dapat dihapus karena sudah lebih dari 12 jam.'
            );
        }

        $attendanceSession->delete();

        return back()->with(
            'success',
            'Absensi berhasil dihapus.'
        );
    }
}
