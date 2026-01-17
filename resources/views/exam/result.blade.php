@extends('layouts.app')

@section('title', 'Hasil Ujian')

@section('content')
<div class="exam-confirm-wrapper">

    <h1 class="page-title">Hasil Ujian</h1>
    <p class="page-subtitle">
        Berikut adalah ringkasan hasil ujian yang telah Anda selesaikan.
    </p>

    <div class="exam-card">

        <div class="exam-info">
            <h2 class="exam-title">
                {{ $session->schedule->event->title }}
            </h2>

            <ul class="exam-meta">
                <li>
                    <strong>Waktu Selesai:</strong>
                    {{ \Carbon\Carbon::parse($session->end_time)->format('d M Y, H:i') }}
                </li>

                <li>
                    <strong>Status:</strong>
                    <span class="badge badge-success">Selesai</span>
                </li>
            </ul>
        </div>

        <hr>

        <div class="exam-result-grid">
            <div class="result-box">
                <div class="result-label">Jawaban Benar</div>
                <div class="result-value">
                    {{ $session->correct_count }}
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Skor Bobot</div>
                <div class="result-value">
                    {{ $session->raw_score }}
                </div>
            </div>

            <div class="result-box highlight">
                <div class="result-label">Nilai Akhir</div>
                <div class="result-value">
                    {{ $session->final_score }}
                </div>
            </div>
        </div>

    </div>

    <div class="exam-action mt-4">
        <a href="{{ route('exam.index') }}" class="btn-primary">
            Kembali ke Daftar Ujian
        </a>
    </div>

</div>
@endsection
