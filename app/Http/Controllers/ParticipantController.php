<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Participant;
use App\Models\WaveProgram;
use App\Models\ParticipantClassroom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ParticipantRequest;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Participant::with('user');

        $participants = $query
            ->withExists('participantClassrooms')
            ->latest()
            ->paginate(10)
            ->withQueryString();
      
        // Pencarian
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nik', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }


        // Filter status
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        // Statistik
        $totalAktif = Participant::where(
            'status',
            'Aktif'
        )->count();


        $totalNonaktif = Participant::where(
            'status',
            '!=',
            'Aktif'
        )->count();


        $participants = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'participants.index',
            compact(
                'participants',
                'totalAktif',
                'totalNonaktif'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Peserta')
            ->doesntHave('participant')
            ->orderBy('name')
            ->get();

        $wavePrograms = WaveProgram::with([
            'wave',
            'program'
        ])
            ->where('is_active', true)
            ->get();

        return view(
            'participants.create',
            compact(
                'users',
                'wavePrograms'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParticipantRequest $request)
    {
        DB::transaction(function () use ($request) {

            // Buat akun user
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]);

            // Beri role Peserta
            $user->assignRole('Peserta');

            // Buat data peserta
            Participant::create([

                'user_id' => $user->id,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'education' => $request->education,
                'job' => $request->job,
                'status' => $request->status,

            ]);
        });

        return redirect()
            ->route('participants.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        $participant->load('user');

        return view('participants.show', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ParticipantRequest $request,
        Participant $participant
    ) {
        // Update user
        $participant->user->update([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

        ]);


        // Update peserta
        $participant->update([

            'nik' => $request->nik,

            'gender' => $request->gender,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'address' => $request->address,

            'education' => $request->education,

            'job' => $request->job,

            'status' => $request->status,

        ]);


        return redirect()
            ->route('participants.index')
            ->with(
                'success',
                'Data peserta berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        // Peserta yang sudah masuk kelas tidak boleh dihapus
        if ($participant->participantClassrooms()->exists()) {

            return redirect()
                ->route('participants.index')
                ->with(
                    'error',
                    'Peserta tidak dapat dihapus karena sudah masuk kelas.'
                );
        }

        // Peserta belum masuk kelas → boleh dihapus
        $participant->user->delete();

        return redirect()
            ->route('participants.index')
            ->with(
                'success',
                'Peserta berhasil dihapus.'
            );
    }
}
