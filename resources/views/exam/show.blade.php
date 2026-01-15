@extends('layouts.app')

@section('title', 'Ujian')

@section('content')
<div class="exam-wrapper">

    <!-- HEADER -->
    <header class="exam-header">
        <div class="exam-header-left">
            <h1 class="exam-name">
                {{ $session->schedule->event->title }}
            </h1>
            <span class="exam-duration">
                Durasi: {{ $session->schedule->duration_minutes }} menit
            </span>
        </div>

        <span
            id="exam-timer"
            class="exam-timer"
            data-remaining="{{ $remainingSeconds }}">
            --:--
        </span>

    </header>

    <!-- BODY -->
    <div class="exam-body">

        <!-- SIDEBAR -->
        <aside class="exam-sidebar">
            <h3 class="sidebar-title">Nomor Soal</h3>

            <div class="question-list">
                @foreach ($examQuestions as $eq)
                @php
                $resp = $session->responses
                ->firstWhere('question_id', $eq->question_id);
                @endphp

                <a
                    href="{{ route('exam.show', [$session->id, 'q' => $eq->order_number]) }}"
                    class="question-number
                {{ $eq->order_number == $activeOrder ? 'active' : '' }}
                {{ $resp && $resp->option_id ? 'answered' : '' }}
                {{ $resp && $resp->is_flagged ? 'flagged' : '' }}
            ">
                    {{ $eq->order_number }}
                </a>
                @endforeach
            </div>

        </aside>


        <!-- CONTENT -->
        <main class="exam-content">

            <!-- STIMULUS -->
            @if ($activeExamQuestion->question->passage)
            <div class="question-passage">
                {!! nl2br(e($activeExamQuestion->question->passage->content)) !!}
            </div>
            @endif


            <!-- QUESTION -->
            <div class="question-box">
                <h2 class="question-text">
                    {{ $activeExamQuestion->order_number }}.
                    {{ $activeExamQuestion->question->content }}
                </h2>
            </div>


            <!-- OPTIONS -->
            <div class="options">
                @foreach ($activeExamQuestion->question->options as $option)
                <label class="option-item">
                    <input
                        type="radio"
                        name="option"
                        value="{{ $option->id }}"
                        data-question-id="{{ $activeExamQuestion->question_id }}"
                        {{ $response && $response->option_id == $option->id ? 'checked' : '' }}>

                    <span class="option-label">{{ $option->label }}</span>
                    <span class="option-text">{{ $option->content }}</span>
                </label>
                @endforeach
            </div>


            <!-- ACTION -->
            <div class="exam-actions">

                {{-- Soal sebelumnya --}}
                <a
                    href="{{ $activeOrder > 1 ? route('exam.show', [$session->id, 'q' => $activeOrder - 1]) : '#' }}"
                    class="btn-exam btn-prev">
                    ◀ Soal sebelumnya
                </a>

                {{-- Ragu-ragu --}}
                <button
                    id="btn-flag"
                    class="btn-exam btn-flag {{ $response && $response->is_flagged ? 'active' : '' }}"
                    type="button"
                    data-question-id="{{ $activeExamQuestion->question_id }}">
                     Ragu-ragu
                </button>

                {{-- Soal berikutnya / selesai --}}
                @if ($activeOrder < $examQuestions->count())
                    <a
                        href="{{ route('exam.show', [$session->id, 'q' => $activeOrder + 1]) }}"
                        class="btn-exam btn-next">
                        Soal berikutnya ▶
                    </a>
                    @else
                    <form
                        method="POST"
                        action="{{ route('exam.submit', $session->id) }}"
                        onsubmit="return confirm('Yakin ingin menyelesaikan ujian?')"
                        style="display: flex; justify-content: flex-end;"
                    >
                        @csrf
                        <button class="btn-exam btn-next">
                            Selesai ▶
                        </button>
                    </form>

                    @endif

            </div>

        </main>
    </div>
</div>

<script>
    window.EXAM_SESSION_ID = "{{ $session->id }}";
</script>

<script src="{{ asset('js/exam.js') }}"></script>
@endsection