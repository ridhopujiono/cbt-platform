@extends('admin.layouts.app')

@section('title', 'Edit Event Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @include('admin.layouts.breadcrumb.index')

        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5>Edit Event Ujian</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('admin.exam-events.update', $event->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Judul Event</label>
                                <input type="text"
                                       name="title"
                                       value="{{ $event->title }}"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="4">{{ $event->description }}</textarea>
                            </div>

                            <button class="btn btn-primary">
                                Update
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
