@extends('admin.layouts.app')

@section('title', 'Jadwal Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Jadwal Ujian</h5>
                <a href="{{ route('admin.exam-schedules.create') }}"
                   class="btn btn-primary btn-sm">
                    + Tambah Jadwal
                </a>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $s)
                        <tr>
                            <td>{{ $s->event->title }}</td>
                            <td>{{ $s->start_at }}</td>
                            <td>{{ $s->end_at }}</td>
                            <td>{{ $s->duration_minutes }} menit</td>
                            <td>
                                @php
                                    if ($s->type == 'flexible') {
                                        $status = 'Fleksibel';
                                    } else {
                                        if (now()->lt($s->start_at)) $status = 'Belum Dibuka';
                                        elseif (now()->gt($s->end_at)) $status = 'Selesai';
                                        else $status = 'Aktif';
                                    }
                                @endphp
                                <span class="badge badge-{{ $s->type == 'flexible' ? 'warning' : 'info' }}">{{ $status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.exam-schedules.edit', $s->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="{{ route('admin.exam-schedules.questions', $s->id) }}"
                                   class="btn btn-sm btn-secondary">
                                    Atur Soal
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $schedules->links() }}

            </div>
        </div>

    </div>
</div>
@endsection
