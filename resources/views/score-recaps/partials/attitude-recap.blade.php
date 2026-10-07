<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-check mr-1"></i>
            Rekap Nilai Sikap Peserta
        </h3>

        <div class="card-tools">
            <a href="{{ route('score-recaps.print-all-attitude', [
                'classroom' => $classroom,
            ]) }}"
                target="_blank"
                class="btn btn-secondary btn-sm"
                title="Cetak Semua Nilai Sikap">
                <i class="fas fa-print mr-1"></i>
                Cetak Semua Nilai Sikap
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="55" class="text-center align-middle">
                            No
                        </th>

                        <th style="min-width: 220px;" class="align-middle">
                            Peserta
                        </th>

                        @foreach ($attitudeTypes as $type)
                            <th class="text-center align-middle" style="min-width: 140px;">
                                {{ $type->name }}
                            </th>
                        @endforeach

                        <th width="120" class="text-center align-middle">
                            Nilai Akhir
                        </th>

                        <th width="130" class="text-center align-middle">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($attitudeRecaps as $recap)
                        <tr>
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="align-middle">
                                <strong>
                                    {{ $recap['participant']->participantWaveProgram->participant->user->name ?? '-' }}
                                </strong>
                            </td>

                            @foreach ($attitudeTypes as $type)
                                <td class="text-center align-middle">
                                    @if (!is_null($recap['scores'][$type->id] ?? null))
                                        <span class="font-weight-bold">
                                            {{ number_format($recap['scores'][$type->id], 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="text-center align-middle">
                                @if (!is_null($recap['final_score']))
                                    <span class="badge badge-success px-3 py-2" style="font-size: 14px;">
                                        {{ number_format($recap['final_score'], 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <a href="{{ route('score-recaps.participant-attitude', [
                                    'classroom' => $classroom,
                                    'participantClassroom' => $recap['participant'],
                                ]) }}"
                                    class="btn btn-info btn-sm" title="Lihat Detail Nilai Sikap">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('score-recaps.print-participant-attitude', [
                                    'classroom' => $classroom,
                                    'participantClassroom' => $recap['participant'],
                                ]) }}"
                                    class="btn btn-sm btn-secondary" target="_blank" title="Cetak Nilai Sikap">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $attitudeTypes->count() + 4 }}" class="text-center text-muted py-5">
                                <i class="fas fa-chart-bar fa-2x mb-3 d-block"></i>

                                <strong>Belum ada data peserta.</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <small class="text-muted">
            <i class="fas fa-info-circle mr-1"></i>
            Nilai akhir merupakan rata-rata dari komponen sikap
            yang telah dinilai.
        </small>
    </div>
</div>
