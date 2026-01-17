@extends('admin.layouts.app')

@section('title', 'Detail Hasil Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        {{-- INFO PESERTA --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5>Informasi Peserta</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="200">Nama Peserta</th>
                        <td>{{ $session->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Ujian</th>
                        <td>{{ $session->schedule->event->title }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-success">
                                {{ ucfirst($session->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Waktu Mulai</th>
                        <td>{{ $session->start_time }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                        <td>{{ $session->end_time }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- RINGKASAN NILAI --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5>Ringkasan Nilai</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h6>Jawaban Benar</h6>
                        <h3>{{ $session->correct_count }}</h3>
                    </div>
                    <div class="col-md-4">
                        <h6>Skor Bobot</h6>
                        <h3>{{ $session->raw_score }}</h3>
                    </div>
                    <div class="col-md-4">
                        <h6>Nilai Akhir</h6>
                        <h3>{{ $session->final_score }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL JAWABAN --}}
        <div class="card">
            <div class="card-header">
                <h5>Detail Jawaban</h5>
            </div>
            <div class="card-body">

                @foreach ($session->schedule->examQuestions as $eq)
                @php
                $question = $eq->question;
                $response = $session->responses
                ->firstWhere('question_id', $question->id);

                $correctOption = $question->options
                ->firstWhere('is_correct', true);
                @endphp

                <div class="mb-4">
                    <div class="d-flex mb-2">
                        <strong>{{ $eq->order_number }}.</strong>
                        {!! $question->content !!}
                    </div>

                    <ul class="list-unstyled mt-2"> {{-- Pakai list-unstyled untuk buang bullet point default --}}
                        @foreach ($question->options as $opt)

                        {{-- Tambahkan d-flex untuk mensejajarkan Label (kiri) dan Konten (kanan) --}}
                        <li class="d-flex align-items-start mb-2"
                            style="
        font-weight: {{ $opt->is_correct ? 'bold' : 'normal' }};
        color: {{ $response && $response->option_id === $opt->id 
                  ? ($opt->is_correct ? 'green' : 'red') 
                  : 'inherit' }};
    ">
                            {{-- KOLOM 1: Label (A., B., C.) --}}
                            <div class="mr-2" style="min-width: 25px;">
                                {{ $opt->label }}.
                            </div>

                            {{-- KOLOM 2: Konten Jawaban & Badge --}}
                            <div class="flex-grow-1 option-content">
                                {{-- Render konten HTML --}}
                                <div class="d-inline-block">
                                    {!! $opt->content !!}
                                </div>

                                {{-- Badge Status --}}
                                @if($opt->is_correct)
                                <span class="badge badge-success ml-2 align-middle">Benar</span>
                                @endif

                                @if($response && $response->option_id === $opt->id && ! $opt->is_correct)
                                <span class="badge badge-danger ml-2 align-middle">Dipilih</span>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    @if($response && $response->is_flagged)
                    <span class="badge badge-warning">Ditandai Ragu-ragu</span>
                    @endif
                </div>
                <hr>
                @endforeach

            </div>
        </div>

    </div>
</div>
@endsection