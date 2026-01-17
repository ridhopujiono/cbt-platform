@extends('admin.layouts.app')

@section('title', 'Tambah Organisasi')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

<div class="card">
    <div class="card-header">
        <h5>Tambah Organisasi</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.organizations.store') }}">
            @csrf

            <div class="form-group">
                <label>Nama Organisasi</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>Tipe Organisasi</label>
                <input type="text"
                       name="type"
                       class="form-control"
                       placeholder="Sekolah / Kampus / Instansi">
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('admin.organizations.index') }}"
               class="btn btn-secondary">
                Batal
            </a>
        </form>
    </div>
</div>

</div>
</div>
@endsection
