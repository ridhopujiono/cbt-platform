@extends('admin.layouts.app')

@section('title', 'Edit Mapel')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Edit Mata Pelajaran</h5>
            </div>

            <div class="card-body">
                <form method="POST"
                      action="{{ route('admin.subjects.update', $subject) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text"
                               name="name"
                               value="{{ $subject->name }}"
                               class="form-control"
                               required>
                    </div>

                    <button class="btn btn-primary">Update</button>
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
