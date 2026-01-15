<?php

namespace App\Http\Controllers;

use App\Models\ExamResponse;
use App\Models\ExamSchedule;
use App\Models\ExamSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ExamController extends Controller
{
    /**
     * Halaman konfirmasi ujian
     */
    public function index()
    {
        $user = Auth::user();
        $now  = now();

        // Ambil semua jadwal ujian (bisa difilter per organisasi nanti)
        $schedules = ExamSchedule::with('event')
            ->orderBy('start_at')
            ->get()
            ->map(function ($schedule) use ($user, $now) {

                $session = ExamSession::where('user_id', $user->id)
                    ->where('schedule_id', $schedule->id)
                    ->latest()
                    ->first();

                // Tentukan status untuk user
                if ($session) {
                    if ($session->status === 'ongoing') {
                        $userStatus = 'ongoing';
                    } elseif ($session->status === 'finished') {
                        $userStatus = 'finished';
                    } else {
                        $userStatus = 'ready';
                    }
                } else {
                    $userStatus = 'not_started';
                }

                // Status jadwal berdasarkan waktu
                if ($now->lt($schedule->start_at)) {
                    $timeStatus = 'not_open';
                } elseif ($now->gt($schedule->end_at)) {
                    $timeStatus = 'closed';
                } else {
                    $timeStatus = 'open';
                }

                return [
                    'schedule'   => $schedule,
                    'userStatus' => $userStatus,
                    'timeStatus' => $timeStatus,
                ];
            });

        return view('exam.index', compact('schedules'));
    }

    /**
     * Mulai ujian (buat / resume session)
     */
    public function start(Request $request)
    {
        $request->validate([
            'schedule_id' => ['required', 'exists:exam_schedules,id'],
        ]);

        $user = Auth::user();
        $now  = now();

        $schedule = ExamSchedule::findOrFail($request->schedule_id);

        // Pastikan jadwal masih dibuka
        if ($now->lt($schedule->start_at) || $now->gt($schedule->end_at)) {
            return redirect()
                ->route('exam.index')
                ->withErrors('Ujian belum dibuka atau sudah ditutup.');
        }

        // Cek session ongoing
        $session = ExamSession::where('user_id', $user->id)
            ->where('schedule_id', $schedule->id)
            ->where('status', 'ongoing')
            ->first();

        // Jika belum ada, buat session baru
        if (! $session) {
            $session = ExamSession::create([
                'user_id'     => $user->id,
                'schedule_id' => $schedule->id,
                'start_time'  => $now,
                'status'      => 'ongoing',
            ]);
        }

        return redirect()->route('exam.show', $session->id);
    }

    /**
     * Halaman ujian (placeholder)
     */
    public function show(ExamSession $session, Request $request)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $schedule = $session->schedule;

        // === TIMER LOGIC (SERVER SIDE) ===
        $endTime = $session->start_time
            ->addMinutes($schedule->duration_minutes);

        $remainingSeconds = now()->diffInSeconds($endTime, false);

        if ($remainingSeconds <= 0) {
            // Waktu habis → paksa submit
            return redirect()
                ->route('exam.submit.force', $session->id);
        }

        // soal (tetap seperti sebelumnya)
        $activeOrder = (int) $request->query('q', 1);

        $examQuestions = Cache::remember(
            "exam:questions:schedule:{$session->schedule_id}",
            now()->addHours(2),
            fn() => $schedule->examQuestions()
                ->with(['question.passage', 'question.options'])
                ->get()
        );

        $activeExamQuestion = $examQuestions
            ->firstWhere('order_number', $activeOrder);

        $session->load('responses');

        $response = $session->responses
            ->firstWhere('question_id', $activeExamQuestion->question_id);

        return view('exam.show', compact(
            'session',
            'examQuestions',
            'activeExamQuestion',
            'response',
            'activeOrder',
            'remainingSeconds'
        ));
    }


    public function autosave(Request $request, ExamSession $session): JsonResponse
    {
        // Pastikan session milik user
        if ($session->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'question_id' => ['required', 'exists:questions,id'],
            'option_id'   => ['nullable', 'exists:options,id'],
            'time_spent'  => ['nullable', 'integer', 'min:0'],
            'is_flagged'  => ['nullable', 'boolean'],
        ]);

        ExamResponse::updateOrCreate(
            [
                'session_id'  => $session->id,
                'question_id' => $validated['question_id'],
            ],
            [
                'option_id'           => $validated['option_id'] ?? null,
                'time_taken_seconds'  => $validated['time_spent'] ?? null,
                'is_flagged'          => $validated['is_flagged'] ?? false,
            ]
        );

        return response()->json([
            'status' => 'ok',
            'saved_at' => now()->toDateTimeString(),
        ]);
    }
}
