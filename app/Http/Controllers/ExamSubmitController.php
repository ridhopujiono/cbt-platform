<?php

namespace App\Http\Controllers;

use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamSubmitController extends Controller
{
    public function submit(ExamSession $session)
    {
        $this->authorizeSession($session);

        if ($session->status === 'finished') {
            return redirect()->route('exam.result', $session->id);
        }

        return $this->finalize($session);
    }

    public function forceSubmit(ExamSession $session)
    {
        $this->authorizeSession($session);

        return $this->finalize($session);
    }

    private function finalize(ExamSession $session)
    {
        DB::transaction(function () use ($session) {

            $schedule = $session->schedule;

            // ===============================
            // HITUNG BATAS AKHIR YANG VALID
            // ===============================
            $sessionEndTime = $session->start_time
                ->copy()
                ->addMinutes($schedule->duration_minutes);

            if ($schedule->isScheduled() && $schedule->end_at) {
                $sessionEndTime = min($sessionEndTime, $schedule->end_at);
            }

            // ===============================
            // LOCK SESSION
            // ===============================
            $session->update([
                'status'   => 'finished',
                'end_time' => now()->greaterThan($sessionEndTime)
                    ? $sessionEndTime
                    : now(),
            ]);

            // ===============================
            // HITUNG NILAI
            // ===============================
            $correctCount = 0;
            $rawScore     = 0;

            $responses = $session->responses()
                ->with(['question.options'])
                ->get();

            foreach ($responses as $response) {
                $correctOption = $response->question->options
                    ->firstWhere('is_correct', true);

                if ($correctOption && $response->option_id === $correctOption->id) {
                    $correctCount++;
                    $rawScore += $response->question->weight;
                }
            }

            // ===============================
            // TOTAL BOBOT SOAL
            // ===============================
            $totalWeight = $schedule->examQuestions()
                ->with('question')
                ->get()
                ->sum(fn ($eq) => $eq->question->weight);

            // ===============================
            // NILAI AKHIR (0–100)
            // ===============================
            $finalScore = $totalWeight > 0
                ? round(($rawScore / $totalWeight) * 100, 2)
                : 0;

            // ===============================
            // SIMPAN HASIL
            // ===============================
            $session->update([
                'correct_count' => $correctCount,
                'raw_score'     => $rawScore,
                'final_score'   => $finalScore,
            ]);
        });

        return redirect()
            ->route('exam.index')
            ->with('success', 'Ujian berhasil diselesaikan.');
    }

    private function authorizeSession(ExamSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        if ($session->status === 'blocked') {
            abort(403, 'Sesi ujian diblokir.');
        }
    }
}
