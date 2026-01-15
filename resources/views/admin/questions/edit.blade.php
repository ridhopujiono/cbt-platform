@extends('admin.layouts.app')

@section('title', 'Edit Soal')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Edit Soal</h5>
                        <button type="button"
                                class="btn btn-outline-primary btn-sm"
                                data-toggle="modal"
                                data-target="#previewModal">
                            Preview Soal
                        </button>
                    </div>

                    <div class="card-body">
                        <form id="question-form"
                            method="POST"
                            action="{{ route('admin.questions.update', $question->id) }}">

                            @csrf
                            @method('PUT')

                            {{-- SUBJECT --}}
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select name="subject_id" class="form-control" required>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ $question->subject_id == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- QUESTION --}}
                            <div class="form-group">
                                <label>Isi Soal</label>
                                <div id="question-editor"
                                     class="math-ignore"
                                     style="height:150px;"></div>
                                <input type="hidden"
                                       name="content"
                                       id="question-content">
                            </div>

                            {{-- WEIGHT --}}
                            <div class="form-group">
                                <label>Bobot Soal</label>
                                <input type="number"
                                       name="weight"
                                       step="0.1"
                                       min="0.1"
                                       value="{{ $question->weight }}"
                                       class="form-control"
                                       required>
                            </div>

                            <hr>

                            {{-- OPTIONS --}}
                            <h6>Pilihan Jawaban</h6>

                            @foreach (['A','B','C','D','E'] as $idx => $label)
                                @php
                                    $opt = $question->options[$idx] ?? null;
                                @endphp

                                <div class="form-group">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio"
                                                   name="correct_option"
                                                   value="{{ $idx }}"
                                                   class="custom-control-input"
                                                   id="correct_{{ $idx }}"
                                                   {{ $opt && $opt->is_correct ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                   for="correct_{{ $idx }}">
                                                Benar
                                            </label>
                                        </div>
                                        <strong>Opsi {{ $label }}</strong>
                                    </div>

                                    <div id="option-editor-{{ $idx }}"
                                         class="math-ignore"
                                         style="height:120px;"></div>

                                    <input type="hidden"
                                           name="options[{{ $idx }}][content]"
                                           id="option-content-{{ $idx }}">
                                </div>
                            @endforeach

                            {{-- ACTION --}}
                            <div class="form-group mt-4">
                                <button class="btn btn-primary">
                                    Update Soal
                                </button>
                                <a href="{{ route('admin.questions.index') }}"
                                   class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- PREVIEW MODAL --}}
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Preview Soal</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <strong>Soal:</strong>
                <div id="preview-question"
                     class="border rounded p-2 mt-1 mb-3"></div>

                <strong>Pilihan Jawaban:</strong>
                <ol type="A" id="preview-options" class="mt-2"></ol>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const quillOptions = {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold','italic','underline'],
                [{'list':'ordered'},{'list':'bullet'}],
                ['image','code-block']
            ]
        }
    };

    // QUESTION EDITOR
    // QUESTION EDITOR
    const questionEditor = new Quill('#question-editor', quillOptions);

    const questionContent = {!! json_encode($question->content) !!};

    if (questionContent && questionContent.trim().startsWith('<')) {
        questionEditor.clipboard.dangerouslyPasteHTML(questionContent);
    } else {
        questionEditor.setText(questionContent || '');
    }



    // OPTION EDITORS
    const optionEditors = [];

    @foreach ($question->options as $i => $opt)
        optionEditors[{{ $i }}] =
            new Quill('#option-editor-{{ $i }}', quillOptions);

        const optContent{{ $i }} = {!! json_encode($opt->content) !!};

        if (optContent{{ $i }} && optContent{{ $i }}.trim().startsWith('<')) {
            optionEditors[{{ $i }}].clipboard.dangerouslyPasteHTML(optContent{{ $i }});
        } else {
            optionEditors[{{ $i }}].setText(optContent{{ $i }} || '');
        }

    @endforeach
</script>

<script>
$('#question-form').on('submit', function (e) {
    e.preventDefault();

    // Inject konten Quill
    $('#question-content').val(questionEditor.root.innerHTML);

    optionEditors.forEach((editor, idx) => {
        $('#option-content-' + idx).val(editor.root.innerHTML);
    });

    const form = $(this);

    $.ajax({
        url: form.attr('action'),      // /admin/questions/{id}
        type: 'POST',                  // ⬅️ WAJIB POST
        data: form.serialize(),        // berisi _method=PUT
        beforeSend: function () {
            form.find('button[type="submit"]').prop('disabled', true);
        },
        success: function () {
            window.location.href = "{{ route('admin.questions.index') }}";
        },
        error: function (xhr) {
            alert('Gagal menyimpan soal');
            console.error(xhr.responseText);
        },
        complete: function () {
            form.find('button[type="submit"]').prop('disabled', false);
        }
    });
});
</script>


<script>
$('#previewModal').on('shown.bs.modal', function () {

    document.getElementById('preview-question').innerHTML =
        '<div class="math-preview">' +
        questionEditor.root.innerHTML +
        '</div>';

    const list = document.getElementById('preview-options');
    list.innerHTML = '';

    optionEditors.forEach((editor, idx) => {
        const li = document.createElement('li');
        li.innerHTML =
            '<div class="math-preview">' +
            (editor.root.innerHTML || '<em>(kosong)</em>') +
            '</div>';

        const radio = document.querySelector(
            'input[name="correct_option"]:checked'
        );

        if (radio && Number(radio.value) === idx) {
            li.innerHTML +=
                ' <span class="badge badge-success ml-2">Jawaban Benar</span>';
        }

        list.appendChild(li);
    });

    if (window.MathJax) {
        MathJax.typesetPromise(
            document.querySelectorAll('.math-preview')
        );
    }
});
</script>
@endpush
