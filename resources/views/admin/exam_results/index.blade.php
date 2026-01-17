@extends('admin.layouts.app')

@section('title', 'Hasil Ujian')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

{{-- FILTER --}}
<div class="card mb-3">
    <div class="card-header">
        <h5>Filter Hasil Ujian</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row">

            <div class="col-md-4">
                <label>Event Ujian</label>
                <select name="event_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Event --</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}"
                            {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Jadwal Ujian</label>
                <select name="schedule_id" class="form-control">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach ($schedules as $sch)
                        <option value="{{ $sch->id }}"
                            {{ request('schedule_id') == $sch->id ? 'selected' : '' }}>
                            {{ $sch->event->title }}
                            ({{ $sch->isFlexible() ? 'Fleksibel' : $sch->start_at }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary">
                    Lihat Hasil
                </button>
            </div>

        </form>
    </div>
</div>

{{-- HASIL --}}
@if(request('schedule_id'))
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Hasil Ujian</h5>

        <a href="{{ route('admin.exam-results.export', request('schedule_id')) }}"
           class="btn btn-success btn-sm">
            Unduh Excel
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Peserta</th>
                    <th>Status</th>
                    <th>Benar</th>
                    <th>Skor Bobot</th>
                    <th>Nilai Akhir</th>
                    <th>Waktu Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sessions as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->user->username }}</td>
                    <td>
                        <span class="badge 
                            {{ $s->status === 'finished' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td>{{ $s->correct_count ?? '-' }}</td>
                    <td>{{ $s->raw_score ?? '-' }}</td>
                    <td>
                        @if($s->final_score !== null)
                            <strong>{{ $s->final_score }}</strong>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $s->end_time ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.exam-results.show', $s->id) }}"
                        class="btn btn-sm btn-outline-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Belum ada hasil ujian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sessions instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="card-footer">
        {{ $sessions->links() }}
    </div>
    @endif
</div>
@endif

</div>
</div>
@endsection
