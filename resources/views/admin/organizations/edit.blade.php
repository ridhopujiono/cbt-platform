@extends('admin.layouts.app')

@section('title', 'Edit Organisasi')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

<div class="card">
    <div class="card-header">
        <h5>Edit Organisasi</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.organizations.update', $organization->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Organisasi</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $organization->name }}"
                       required>
            </div>

            <div class="form-group">
                <label>Tipe Organisasi</label>
                <input type="text"
                       name="type"
                       class="form-control"
                       value="{{ $organization->type }}">
            </div>

            <button class="btn btn-primary">
                Update
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
