@extends('admin.layouts.app')

@section('title', 'Atur Soal Ujian')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

{{-- INFO JADWAL --}}
<div class="card mb-3">
    <div class="card-body">
        <strong>Event:</strong> {{ $schedule->event->title }} <br>
        <strong>Waktu:</strong> {{ $schedule->start_at }} – {{ $schedule->end_at }} <br>
        <strong>Durasi:</strong> {{ $schedule->duration_minutes }} menit
    </div>
</div>

<div class="card">
<div class="card-header">
    <h5>Pilih Soal</h5>
</div>

<div class="card-body">

{{-- FILTER --}}
<form method="GET" class="mb-3" id="questions-filter">
    <div class="row">
        <div class="col-md-4">
            <select name="subject_id" class="form-control">
                <option value="">-- Semua Mapel --</option>
                @foreach ($subjects as $s)
                    <option value="{{ $s->id }}"
                        {{ request('subject_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="text"
                   name="keyword"
                   value="{{ request('keyword') }}"
                   class="form-control"
                   placeholder="Cari soal...">
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary">
                Filter
            </button>
        </div>
    </div>
</form>

{{-- FORM SIMPAN --}}
<form method="POST"
      id="questions-form"
      action="{{ route('admin.exam-schedules.questions.update', $schedule->id) }}">
@csrf

<div id="questions-table">
    @include('admin.exam_schedules.partials.questions_table')
</div>

<div class="mt-3">
    <button class="btn btn-success">
        Simpan Soal
    </button>

    <a href="{{ route('admin.exam-schedules.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>
</div>

</form>

</div>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
/**
 * ===============================
 * STATE MANAGEMENT (PENTING)
 * ===============================
 */
const selectedQuestions = new Set(@json($selected));

const filterForm = document.getElementById('questions-filter');
const questionsTable = document.getElementById('questions-table');
const form = document.getElementById('questions-form');
const filterUrl = @json(route('admin.exam-schedules.questions', $schedule->id));

/**
 * Load soal via AJAX
 */
const loadQuestions = async (url) => {
    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    questionsTable.innerHTML = await res.text();

    // Restore checklist state
    selectedQuestions.forEach(id => {
        const checkbox = questionsTable.querySelector(
            `input[type="checkbox"][value="${id}"]`
        );
        if (checkbox) checkbox.checked = true;
    });
};

/**
 * FILTER SUBMIT
 */
filterForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const params = new URLSearchParams(new FormData(filterForm));
    loadQuestions(`${filterUrl}?${params.toString()}`);
});

/**
 * PAGINATION AJAX
 */
questionsTable.addEventListener('click', function (e) {
    const link = e.target.closest('.pagination a');
    if (!link) return;

    e.preventDefault();
    loadQuestions(link.getAttribute('href'));
});

/**
 * CHECKBOX CHANGE
 */
questionsTable.addEventListener('change', function (e) {
    if (!e.target.matches('input[type="checkbox"][name="questions[]"]')) return;

    const id = Number(e.target.value);
    if (e.target.checked) {
        selectedQuestions.add(id);
    } else {
        selectedQuestions.delete(id);
    }
});

/**
 * SUBMIT FINAL
 * Inject ulang semua selectedQuestions
 */
form.addEventListener('submit', function () {

    // hapus input lama
    form.querySelectorAll('input[name="questions[]"]').forEach(el => el.remove());

    // inject dari state JS
    selectedQuestions.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'questions[]';
        input.value = id;
        form.appendChild(input);
    });

});
</script>
@endpush
