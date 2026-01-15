@extends('admin.layouts.app')

@section('title', 'Tambah Soal')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                   <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Tambah Soal Baru</h5>
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
                            action="{{ route('admin.questions.store') }}">
                            @csrf

                            @csrf

                            {{-- SUBJECT --}}
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select name="subject_id"
                                        class="form-control"
                                        required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- QUESTION --}}
                            <div class="form-group">
                                <label>Isi Soal</label>
                                <div id="question-editor" style="height:150px;"></div>
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
                                       value="1"
                                       class="form-control"
                                       required>
                            </div>

                            <hr>

                            <!-- <small class="form-text text-muted">
                            Gunakan format LaTeX dengan tanda <code>$</code><br>
                            Contoh:
                            <code>$\sqrt{2}$</code>,
                            <code>$\frac{a}{b}$</code>,
                            <code>$x^2$</code>
                            </small> -->

                            {{-- OPTIONS --}}
                            <h6>Pilihan Jawaban</h6>

                            @foreach (['A','B','C','D','E'] as $idx => $label)
                                <div class="form-group">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio"
                                                   name="correct_option"
                                                   value="{{ $idx }}"
                                                   class="custom-control-input"
                                                   id="correct_{{ $idx }}"
                                                   required>
                                            <label class="custom-control-label"
                                                   for="correct_{{ $idx }}">
                                                Benar
                                            </label>
                                        </div>
                                        <strong>Opsi {{ $label }}</strong>
                                    </div>

                                    <div id="option-editor-{{ $idx }}"
                                         style="height:120px;"></div>

                                    <input type="hidden"
                                           name="options[{{ $idx }}][content]"
                                           id="option-content-{{ $idx }}">
                                </div>
                            @endforeach

                            {{-- ACTION --}}
                            <div class="form-group mt-4">
                                <button type="button"
                                        id="btn-save"
                                        class="btn btn-primary">
                                    Simpan Soal
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

                <div class="mb-3">
                    <strong>Soal:</strong>
                    <div id="preview-question"
                         class="border rounded p-2 mt-1">
                    </div>
                </div>

                <div>
                    <strong>Pilihan Jawaban:</strong>
                    <ol type="A" id="preview-options" class="mt-2"></ol>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
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

    const questionEditor = new Quill('#question-editor', quillOptions);

    const optionEditors = [];
    @foreach (['A','B','C','D','E'] as $idx => $label)
        optionEditors[{{ $idx }}] =
            new Quill('#option-editor-{{ $idx }}', quillOptions);
    @endforeach
</script>

<script>
    $('#previewModal').on('shown.bs.modal', function () {

    // CLONE konten soal (bukan referensi asli)
    const questionHtml = questionEditor.root.innerHTML;
    document.getElementById('preview-question').innerHTML =
        '<div class="math-preview">' + questionHtml + '</div>';

    // Opsi
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

    // ⛔ MathJax hanya memproses preview, BUKAN editor
    if (window.MathJax) {
        MathJax.typesetPromise(
            document.querySelectorAll('.math-preview')
        );
    }
});
</script>

<script>
(function () {

    const btnSave = document.getElementById('btn-save');
    const form    = document.getElementById('question-form');

    if (!btnSave || !form) {
        console.error('Form atau button tidak ditemukan');
        return;
    }

    btnSave.addEventListener('click', async function () {

        // === KUMPULKAN DATA DARI QUILL ===
        const payload = {
            _token: document.querySelector('input[name="_token"]').value,
            subject_id: form.querySelector('[name="subject_id"]').value,
            weight: form.querySelector('[name="weight"]').value,
            correct_option: document.querySelector(
                'input[name="correct_option"]:checked'
            )?.value ?? null,
            content: questionEditor.root.innerHTML,
            options: []
        };

        optionEditors.forEach((editor, idx) => {
            payload.options.push({
                content: editor.root.innerHTML
            });
        });

        // === DEBUG PAYLOAD ===
        console.log('PAYLOAD YANG DIKIRIM:', payload);

        // === VALIDASI CLIENT SEDERHANA ===
        if (!payload.content || payload.content === '<p><br></p>') {
            alert('Isi soal masih kosong');
            return;
        }

        if (payload.correct_option === null) {
            alert('Pilih jawaban yang benar');
            return;
        }

        // === KIRIM AJAX ===
        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': payload._token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();

            console.log('RESPONSE:', result);

            if (!res.ok) {
                alert(result.message || 'Gagal menyimpan');
                return;
            }

            // sukses → redirect
            window.location.href = result.redirect;

        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan');
        }

    });

})();
</script>


@endpush
