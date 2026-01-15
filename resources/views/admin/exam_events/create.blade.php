@extends('admin.layouts.app')

@section('title', 'Tambah Event Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @include('admin.layouts.breadcrumb.index')

        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5>Tambah Event Ujian</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('admin.exam-events.store') }}">
                            @csrf

                            <div class="form-group">
                                <label>Judul Event</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="4"></textarea>
                            </div>

                            <button class="btn btn-primary">
                                Simpan
                            </button>
                            <a href="{{ route('admin.exam-events.index') }}"
                               class="btn btn-secondary">
                                Batal
                            </a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
