@extends('admin.layouts.app')

@section('title', 'Bank Soal')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @include('admin.layouts.breadcrumb.index')
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="subject_id" class="form-control">
                                        <option value="">-- Semua Mata Pelajaran --</option>
                                        @foreach($subjects as $s)
                                        <option value="{{ $s->id }}"
                                            {{ request('subject_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <input type="text"
                                        name="q"
                                        class="form-control"
                                        placeholder="Cari soal..."
                                        value="{{ request('q') }}">
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.questions.index') }}"
                                        class="btn btn-secondary">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Bank Soal</h5>
                        <div>
                            <button class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#previewBankModal">
                                Preview Bank Soal
                            </button>
    
                            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-sm">
                                + Tambah Soal
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Soal</th>
                                    <th>Bobot</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $q)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $q->subject->name ?? '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($q->content), 80) }}</td>
                                    <td>{{ $q->weight }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                class="custom-control-input toggle-status"
                                                id="switch{{ $q->id }}"
                                                data-id="{{ $q->id }}"
                                                {{ $q->status === 'published' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="switch{{ $q->id }}">
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.questions.edit', $q->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewBankModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Preview Bank Soal</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

        <select id="preview-subject" class="form-control mb-3">
            <option value="">-- Pilih Mata Pelajaran --</option>
            @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>

        <div id="preview-content"></div>

      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
document.querySelectorAll('.toggle-status').forEach(el => {
    el.addEventListener('change', function () {
        fetch(`/admin/questions/${this.dataset.id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
    });
});
</script>

<script>
document.getElementById('preview-subject').addEventListener('change', async function () {

    const res = await fetch(`/admin/questions/preview/by-subject/${this.value}`);
    const data = await res.json();

    const wrap = document.getElementById('preview-content');
    wrap.innerHTML = '';

    data.forEach((q, i) => {
        let html = `
            <div class="mb-4">
                <strong>${i+1}. </strong>
                <div class="math-preview">${q.content}</div>
                <ol type="A">
        `;

        q.options.forEach(opt => {
            html += `
                <li>
                    <div class="math-preview">
                        ${opt.content}
                        ${opt.is_correct ? '<span class="badge badge-success ml-2">Benar</span>' : ''}
                    </div>
                </li>`;
        });

        html += '</ol></div>';
        wrap.innerHTML += html;
    });

    if (window.MathJax) {
        MathJax.typesetPromise();
    }
});
</script>

@endpush