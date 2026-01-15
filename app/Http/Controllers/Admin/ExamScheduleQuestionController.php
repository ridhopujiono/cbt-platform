<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamQuestion;
use App\Models\ExamSchedule;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamScheduleQuestionController extends Controller
{
    public function edit(Request $request, ExamSchedule $schedule)
    {
        $subjects = Subject::orderBy('name')->get();

        $questions = Question::with('subject')
            ->when($request->subject_id, function ($query) use ($request) {
                $query->where('subject_id', $request->subject_id);
            })
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('content', 'like', '%' . $request->keyword . '%');
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $selected = ExamQuestion::where('schedule_id', $schedule->id)
            ->orderBy('order_number')
            ->pluck('question_id')
            ->toArray();

        if ($request->ajax()) {
            return view(
                'admin.exam_schedules.partials.questions_table',
                compact('questions', 'selected')
            );
        }

        return view(
            'admin.exam_schedules.questions',
            compact('schedule', 'questions', 'subjects', 'selected')
        );
    }

    public function update(Request $request, ExamSchedule $schedule)
    {
        $request->validate([
            'questions' => 'required|array|min:1',
        ]);

        ExamQuestion::where('schedule_id', $schedule->id)->delete();

        foreach ($request->questions as $index => $questionId) {
            ExamQuestion::create([
                'schedule_id' => $schedule->id,
                'question_id' => $questionId,
                'order_number' => $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.exam-schedules.index')
            ->with('success', 'Soal berhasil diatur.');
    }
}
