<table>
    <thead>

        {{-- Judul --}}

        <tr>
            <th colspan="{{ $participants->count() + 2 }}">
                LAPORAN KEHADIRAN PESERTA
            </th>
        </tr>

        <tr>
            <th colspan="{{ $participants->count() + 2 }}">
                LPK MIRAI GRESIK
            </th>
        </tr>


        {{-- Informasi --}}

        <tr>
            <th>Program</th>

            <th colspan="{{ $participants->count() + 1 }}">
                {{ $classroom?->waveProgram?->program?->name ?? 'Semua Program' }}
            </th>
        </tr>


        <tr>
            <th>Gelombang</th>

            <th colspan="{{ $participants->count() + 1 }}">
                {{ $classroom?->waveProgram?->wave?->name ?? 'Semua Gelombang' }}
            </th>
        </tr>


        <tr>
            <th>Kelas</th>

            <th colspan="{{ $participants->count() + 1 }}">
                {{ $classroom?->name ?? 'Semua Kelas' }}
            </th>
        </tr>


        <tr>
            <th colspan="{{ $participants->count() + 2 }}">
            </th>
        </tr>


        {{-- Header tabel --}}

        <tr>

            <th>
                Tanggal
            </th>

            <th>
                Materi
            </th>

            @foreach ($participants as $participant)

                <th>
                    {{ $participant->participantWaveProgram->participant->user->name }}
                </th>

            @endforeach

        </tr>

    </thead>


    <tbody>

        @forelse ($attendanceSessions as $session)

            <tr>

                {{-- Tanggal --}}

                <td>
                    {{ \Carbon\Carbon::parse($session->attendance_date)->format('d/m/Y') }}
                </td>


                {{-- Materi --}}

                <td>
                    {{ $session->schedule->subject ?? '-' }}
                </td>


                {{-- Kehadiran peserta --}}

                @foreach ($participants as $participant)

                    @php

                        $attendance = $session->attendances
                            ->firstWhere(
                                'participant_classroom_id',
                                $participant->id
                            );

                    @endphp


                    <td>

                        @if ($attendance)

                            @switch($attendance->status)

                                @case('Hadir')
                                    H
                                    @break

                                @case('Izin')
                                    I
                                    @break

                                @case('Sakit')
                                    S
                                    @break

                                @case('Alpha')
                                    A
                                    @break

                                @default
                                    -
                            @endswitch

                        @else

                            -

                        @endif

                    </td>

                @endforeach

            </tr>

        @empty

            <tr>

                <td colspan="{{ $participants->count() + 2 }}">

                    Belum ada data kehadiran.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>