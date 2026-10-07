<table>

    <thead>

        {{-- Judul --}}

        <tr>

            <th colspan="{{ $participants->count() + 3 }}">
                LAPORAN NILAI SIKAP PESERTA
            </th>

        </tr>

        <tr>

            <th colspan="{{ $participants->count() + 3 }}">
                LPK MIRAI GRESIK
            </th>

        </tr>

        <tr>

            <th colspan="{{ $participants->count() + 3 }}">
                Nomor :
                LP/SIKAP/{{ now()->format('Ym') }}/{{ str_pad($participants->count(), 4, '0', STR_PAD_LEFT) }}
            </th>

        </tr>


        {{-- Informasi --}}

        <tr>

            <th>Program</th>

            <th colspan="{{ $participants->count() + 2 }}">
                {{ $classroom?->waveProgram?->program?->name ?? 'Semua Program' }}
            </th>

        </tr>


        <tr>

            <th>Gelombang</th>

            <th colspan="{{ $participants->count() + 2 }}">
                {{ $classroom?->waveProgram?->wave?->name ?? 'Semua Gelombang' }}
            </th>

        </tr>


        <tr>

            <th>Kelas</th>

            <th colspan="{{ $participants->count() + 2 }}">
                {{ $classroom?->name ?? 'Semua Kelas' }}
            </th>

        </tr>


        <tr>

            <th colspan="{{ $participants->count() + 3 }}">
            </th>

        </tr>


        {{-- Header tabel --}}

        <tr>

            <th>
                Minggu
            </th>

            <th>
                Tanggal
            </th>

            <th>
                Penilaian
            </th>

            @foreach ($participants as $participant)

                <th>

                    {{ $participant->participantWaveProgram->participant->user->name }}

                </th>

            @endforeach

        </tr>

    </thead>


    <tbody>

        @forelse ($attitudeSessions as $session)

            @foreach ($session->sessionTypes as $sessionType)

                @php

                    $attitudeTypeId = $sessionType->attitude_type_id;

                @endphp

                <tr>

                    {{-- Minggu --}}

                    <td>

                        {{ $session->week }}

                    </td>


                    {{-- Tanggal --}}

                    <td>

                        {{ $session->assessment_date
                            ? $session->assessment_date->format('d/m/Y')
                            : '-' }}

                    </td>


                    {{-- Jenis sikap --}}

                    <td>

                        {{ $sessionType->type->name ?? '-' }}

                    </td>


                    {{-- Nilai peserta --}}

                    @foreach ($participants as $participant)

                        @php

                            $score = $session->scores
                                ->where(
                                    'participant_classroom_id',
                                    $participant->id
                                )
                                ->where(
                                    'attitude_type_id',
                                    $attitudeTypeId
                                )
                                ->first();

                        @endphp


                        <td>

                            {{ $score
                                ? number_format($score->score, 2)
                                : '-' }}

                        </td>

                    @endforeach

                </tr>

            @endforeach

        @empty

            <tr>

                <td colspan="{{ $participants->count() + 3 }}">

                    Belum ada data penilaian sikap.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>