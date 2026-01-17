@extends('layouts.app')

@section('title', 'Konfirmasi Ujian')

@section('content')
<div class="exam-confirm-wrapper">

    @if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h1 class="page-title">Konfirmasi Ujian</h1>
    <p class="page-subtitle">
        Pilih ujian yang akan Anda ikuti
    </p>

    @forelse ($schedules as $item)
    @php
    $schedule = $item['schedule'];
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
                <li><strong>Waktu:</strong>
                    @if ($schedule->isFlexible())
                    Fleksibel
                    @else
                    {{ Date::parse($schedule->start_at)->format('d-m-Y H:i') }} – {{ Date::parse($schedule->end_at)->format('d-m-Y H:i') }}
                    @endif
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
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <button class="btn-disabled" disabled>
                    Selesai
                </button>

                @php
                $finishedSession = $schedule->sessions
                ->where('user_id', auth()->id())
                ->where('status','finished')
                ->sortByDesc('end_time')
                ->first();
                @endphp

                <!-- <a href="{{ route('exam.result', $finishedSession->id) }}"
                    Lihat Hasil
                </a> -->
                 <button class="btn btn-success">
                    <a href="{{ route('exam.result', $finishedSession->id) }}">Lihat Hasil</a>
                </button>
            </div>

            @elseif ($timeStatus === 'open')
            @if ($schedule->examQuestions->count() > 0)
            <form method="POST" action="{{ route('exam.start') }}">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <button class="btn btn-primary">
                    Mulai Ujian
                </button>
            </form>
            @else
            <button class="btn-disabled" disabled
                title="Soal ujian belum tersedia">
                Belum Tersedia
            </button>
            @endif

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