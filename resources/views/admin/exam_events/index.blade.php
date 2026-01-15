@extends('admin.layouts.app')

@section('title', 'Event Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @include('admin.layouts.breadcrumb.index')

        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between">
                        <h5>Event Ujian</h5>
                        <a href="{{ route('admin.exam-events.create') }}"
                           class="btn btn-primary btn-sm">
                            + Tambah Event
                        </a>
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
                                    <th>Judul Event</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($events as $event)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ Str::limit($event->description, 80) }}</td>
                                        <td>
                                            <a href="{{ route('admin.exam-events.edit', $event->id) }}"
                                               class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada event ujian
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $events->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
