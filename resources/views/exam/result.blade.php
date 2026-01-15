@extends('layouts.app')

@section('title', 'Hasil Ujian')

@section('content')
<div class="exam-confirm-wrapper">
    <h1 class="page-title">Ujian Selesai</h1>
    <p class="page-subtitle">
        Terima kasih telah mengikuti ujian.
    </p>

    <div class="exam-card">
        <ul class="exam-meta">
            <li><strong>Nama Ujian:</strong> {{ $session->schedule->event->title }}</li>
            <li><strong>Waktu Selesai:</strong> {{ $session->end_time }}</li>
            <li><strong>Jawaban Benar:</strong> {{ $session->correct_count }}</li>
            <li><strong>Skor Bobot:</strong> {{ $session->raw_score }}</li>
            <li><strong>Nilai Akhir:</strong> {{ $session->final_score }}</li>
        </ul>
    </div>
</div>
@endsection