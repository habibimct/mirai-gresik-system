<table>

    <tr>
        <td colspan="14" align="center">
            <strong style="font-size:18px">
                LPK MIRAI GRESIK
            </strong>
        </td>
    </tr>

    <tr>
        <td colspan="14" align="center">
            <strong style="font-size:15px">
                LAPORAN DATA PESERTA
            </strong>
        </td>
    </tr>

    <tr>

        <td colspan="14" align="center">

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

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>NIK</th>
            <th>JK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th>Program</th>
            <th>Gelombang</th>
            <th>Kelas</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($participants as $p)
            @php
                $participant = $p->participantWaveProgram->participant;
                $user = $participant->user;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $participant->nik }}</td>
                <td>
                    {{ $participant->gender == 'L' ? 'Laki-laki' : ($participant->gender == 'P' ? 'Perempuan' : '-') }}
                </td>
                <td>{{ $participant->birth_place }}</td>
                <td>
                    {{ $participant->birth_date }}
                </td>
                <td>{{ $participant->education }}</td>
                <td>{{ $participant->job }}</td>
                <td>
                    {{ $p->participantWaveProgram->waveProgram->program->name }}
                </td>
                <td>
                    {{ $p->classroom->waveProgram->wave->name }}
                </td>
                <td>
                    {{ $p->classroom->name }}
                </td>
                <td>
                    {{ $p->participantWaveProgram->status }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tr>
        <td>
            <strong>
                Total Peserta :
                {{ $participants->count() }}
            </strong>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td colspan="2">
            <strong>Ringkasan</strong>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Total Peserta</td>
        <td>: {{ $total }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Peserta Aktif</td>
        <td>: {{ $totalActive }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Peserta Lulus</td>
        <td>: {{ $totalGraduate }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Peserta Nonaktif</td>
        <td>: {{ $totalInactive }}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td width="40%"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">
            Gresik, {{ now()->translatedFormat('d F Y') }}
            <br>
            Mengetahui,
            <br><br><br><br><br>
            _______________________
        </td>
    </tr>
</table>
