<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamEvent;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $schedules = ExamSchedule::with('event')
            ->orderBy('start_at')
            ->paginate(10);

        return view('admin.exam_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $events = ExamEvent::orderBy('title')->get();

        return view('admin.exam_schedules.create', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:scheduled,flexible',
            'event_id' => 'required|exists:exam_events,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
            'duration_minutes' => 'required',
        ]);

        ExamSchedule::create([
            'event_id' => $data['event_id'],
            'type' => $data['type'],
            'start_at' => $data['type'] === 'scheduled' ? $data['start_at'] : null,
            'end_at' => $data['type'] === 'scheduled' ? $data['end_at'] : null,
            'duration_minutes' => $data['duration_minutes'],
            'is_active' => true,
        ]);


        return redirect()
            ->route('admin.exam-schedules.index')
            ->with('success', 'Jadwal ujian berhasil dibuat.');
    }

    public function edit(ExamSchedule $schedule)
    {
        $events = ExamEvent::orderBy('title')->get();

        return view('admin.exam_schedules.edit', compact('schedule', 'events'));
    }

    public function update(Request $request, ExamSchedule $schedule)
    {
        $data = $request->validate([
            'type' => 'required|in:scheduled,flexible',
            'event_id' => 'required|exists:exam_events,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $schedule->update([
            'event_id' => $data['event_id'],
            'type' => $data['type'],
            'start_at' => $data['type'] === 'scheduled' ? $data['start_at'] : null,
            'end_at' => $data['type'] === 'scheduled' ? $data['end_at'] : null,
            'duration_minutes' => $data['duration_minutes'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.exam-schedules.index')
            ->with('success', 'Jadwal ujian diperbarui.');
    }
}
