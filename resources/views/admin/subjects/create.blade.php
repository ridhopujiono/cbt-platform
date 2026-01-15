@extends('admin.layouts.app')

@section('title', 'Tambah Mapel')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Tambah Mata Pelajaran</h5>
            </div>

            <div class="card-body">
                <form method="POST"
                      action="{{ route('admin.subjects.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               required>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.subjects.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
