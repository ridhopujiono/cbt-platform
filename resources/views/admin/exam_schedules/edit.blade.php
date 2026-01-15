@extends('admin.layouts.app')

@section('title', 'Edit Jadwal Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Edit Jadwal Ujian</h5>
            </div>

            <div class="card-body">
                <form method="POST"
                    action="{{ route('admin.exam-schedules.update', $schedule->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Tipe Ujian</label>
                        <select name="type" id="exam-type" class="form-control">
                            <option value="scheduled" {{ $schedule->type == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="flexible" {{ $schedule->type == 'flexible' ? 'selected' : '' }}>Bebas (Kapan Saja)</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Event</label>
                        <select name="event_id" class="form-control" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                            <option value="{{ $event->id }}"
                                {{ $schedule->event_id == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="schedule-time">
                        <div class="form-group">
                            <label>Mulai</label>
                            <input type="datetime-local"
                                name="start_at"
                                value="{{ optional($schedule->start_at)->format('Y-m-d\TH:i') }}"
                                class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Selesai</label>
                            <input type="datetime-local"
                                name="end_at"
                                value="{{ optional($schedule->end_at)->format('Y-m-d\TH:i') }}"
                                class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Durasi (menit)</label>
                        <input type="number"
                            name="duration_minutes"
                            value="{{ $schedule->duration_minutes }}"
                            class="form-control"
                            min="1"
                            required>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.exam-schedules.index') }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection