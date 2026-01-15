@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal Ujian')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Tambah Jadwal Ujian</h5>
            </div>

            <div class="card-body">
                <form method="POST"
                    action="{{ route('admin.exam-schedules.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Tipe Ujian</label>
                        <select name="type" id="exam-type" class="form-control">
                            <option value="scheduled"
                                {{ old('type', $schedule->type ?? '') === 'scheduled' ? 'selected' : '' }}>
                                Terjadwal
                            </option>
                            <option value="flexible"
                                {{ old('type', $schedule->type ?? '') === 'flexible' ? 'selected' : '' }}>
                                Bebas (Kapan Saja)
                            </option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Event</label>
                        <select name="event_id" class="form-control" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                            <option value="{{ $event->id }}">
                                {{ $event->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="schedule-time">
                        <div class="form-group">
                            <label>Mulai</label>
                            <input type="datetime-local" name="start_at" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Selesai</label>
                            <input type="datetime-local" name="end_at" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Durasi (menit)</label>
                        <input type="number"
                            name="duration_minutes"
                            class="form-control"
                            min="1"
                            required>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.exam-schedules.index') }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeSelect = document.getElementById('exam-type');
    const timeBox = document.getElementById('schedule-time');

    function toggleTime() {
        timeBox.style.display =
            typeSelect.value === 'flexible' ? 'none' : 'block';
    }

    typeSelect.addEventListener('change', toggleTime);
    toggleTime();
</script>

@endpush