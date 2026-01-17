<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamEvent;
use App\Models\ExamSchedule;
use App\Models\ExamSession;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index(Request $request)
    {
        // Dropdown data
        $events = ExamEvent::orderBy('title')->get();

        $schedules = ExamSchedule::with('event')
            ->when($request->event_id, function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            })
            ->orderBy('start_at', 'desc')
            ->get();

        // Jika belum pilih jadwal, jangan load hasil
        $sessions = collect();

        if ($request->filled('schedule_id')) {
            $sessions = ExamSession::with(['user', 'schedule.event'])
                ->where('schedule_id', $request->schedule_id)
                ->orderBy('final_score', 'desc')
                ->paginate(20)
                ->withQueryString();
        }

        return view('admin.exam_results.index', compact(
            'events',
            'schedules',
            'sessions'
        ));
    }
}
