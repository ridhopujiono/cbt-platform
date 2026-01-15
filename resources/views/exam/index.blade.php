@extends('layouts.app')

@section('title', 'Konfirmasi Ujian')

@section('content')
<div class="exam-confirm-wrapper">

    <h1 class="page-title">Konfirmasi Ujian</h1>
    <p class="page-subtitle">
        Pilih ujian yang akan Anda ikuti
    </p>

    @forelse ($schedules as $item)
        @php
            $schedule   = $item['schedule'];
            $userStatus = $item['userStatus'];
            $timeStatus = $item['timeStatus'];
        @endphp

        <div class="exam-card">

            <div class="exam-info">
                <h2 class="exam-title">
                    {{ $schedule->event->title }}
                </h2>

                <ul class="exam-meta">
                    <li><strong>Durasi:</strong> {{ $schedule->duration_minutes }} menit</li>
                    <li>
                        <strong>Waktu:</strong>
                        {{ $schedule->start_at->format('H:i') }}
                        –
                        {{ $schedule->end_at->format('H:i') }}
                    </li>
                </ul>

                <div class="exam-status">
                    @if($schedule->isFlexible())
                    <span class="badge badge-info">Bebas</span>
                    @elseif ($userStatus === 'ongoing')
                        <span class="badge badge-warning">Sedang Berlangsung</span>
                    @elseif ($userStatus === 'finished')
                        <span class="badge badge-success">Selesai</span>
                    @elseif ($timeStatus === 'not_open')
                        <span class="badge badge-muted">Belum Dibuka</span>
                    @elseif ($timeStatus === 'closed')
                        <span class="badge badge-muted">Sudah Ditutup</span>
                    @else
                        <span class="badge badge-info">Siap Dikerjakan</span>
                    @endif
                </div>
            </div>

            <div class="exam-action">
                @if ($userStatus === 'ongoing')
                    <a href="{{ route('exam.show', $schedule->sessions->where('user_id', auth()->id())->where('status','ongoing')->first()->id ?? '#') }}"
                    class="btn-primary">
                    Lanjutkan
                    </a>
                @elseif ($userStatus === 'finished')
                    <button class="btn-disabled" disabled>
                        Selesai
                    </button>
                @elseif ($timeStatus === 'open')
                    <form method="POST" action="{{ route('exam.start') }}">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <button type="submit" class="btn-primary">
                            Mulai Ujian
                        </button>
                    </form>
                @else
                    <button class="btn-disabled" disabled>
                        Tidak Tersedia
                    </button>
                @endif
            </div>

        </div>
    @empty
        <p>Tidak ada ujian yang tersedia.</p>
    @endforelse

</div>
@endsection
