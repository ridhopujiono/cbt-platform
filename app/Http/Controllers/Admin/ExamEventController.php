<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamEvent;
use Illuminate\Http\Request;

class ExamEventController extends Controller
{
    public function index()
    {
        $events = ExamEvent::latest()->paginate(10);

        return view('admin.exam_events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.exam_events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ExamEvent::create($validated);

        return redirect()
            ->route('admin.exam-events.index')
            ->with('success', 'Event ujian berhasil dibuat.');
    }

    public function edit(ExamEvent $event)
    {
        return view('admin.exam_events.edit', compact('event'));
    }

    public function update(Request $request, ExamEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->update($validated);

        return redirect()
            ->route('admin.exam-events.index')
            ->with('success', 'Event ujian berhasil diperbarui.');
    }
}
