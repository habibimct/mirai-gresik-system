<table>

    <tr>
        <td colspan="10" align="center">
            <strong style="font-size:18px">
                LPK MIRAI GRESIK
            </strong>
        </td>
    </tr>

    <tr>
        <td colspan="10" align="center">
            <strong style="font-size:15px">
                LAPORAN AKADEMIK
            </strong>
        </td>
    </tr>

    <tr>

        <td colspan="10" align="center">

            Nomor :
            LP/{{ now()->format('Ym') }}/{{ str_pad($participants->count(), 4, '0', STR_PAD_LEFT) }}

        </td>

    </tr>

</table>
<br>
<table>
    <tr>
        <td width="20%"><strong>Identitas</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>Program</td>
        <td>
            : {{ $program?->name ?? 'Semua Program' }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Gelombang</td>
        <td>
            : {{ $wave?->name ?? 'Semua Gelombang' }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Kelas</td>
        <td>
            : {{ $classroom?->name ?? 'Semua Kelas' }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Status</td>
        <td>
            : {{ $request->status ?? 'Semua Status' }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Tanggal Cetak</td>
        <td>
            : {{ now()->format('d F Y H:i') }}
        </td>
    </tr>
</table>

<br>

<table border="1">

    <thead>

        <tr>

            <th>No</th>

            <th>Peserta</th>

            <th>Program</th>

            <th>Gelombang</th>

            <th>Kelas</th>

            <th>Hadir</th>

            <th>Izin</th>

            <th>Sakit</th>

            <th>Alpha</th>

            <th>Nilai</th>

        </tr>

    </thead>

    <tbody>

        @foreach ($participants as $participant)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $participant->participantWaveProgram->participant->user->name }}</td>

                <td>{{ $participant->participantWaveProgram->waveProgram->program->name }}</td>

                <td>{{ $participant->classroom->waveProgram->wave->name }}</td>

                <td>{{ $participant->classroom->name }}</td>

                <td>{{ $participant->attendances->where('status', 'Hadir')->count() }}</td>

                <td>{{ $participant->attendances->where('status', 'Izin')->count() }}</td>

                <td>{{ $participant->attendances->where('status', 'Sakit')->count() }}</td>

                <td>{{ $participant->attendances->where('status', 'Alpha')->count() }}</td>

                <td>{{ number_format($participant->scores->avg('score') ?? 0, 2) }}</td>

            </tr>
        @endforeach

    </tbody>

</table>


