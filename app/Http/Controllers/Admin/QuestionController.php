<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with('subject')
            ->when($request->subject_id, function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            })
            ->when($request->q, function ($q) use ($request) {
                $q->where('content', 'like', '%' . $request->q . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.questions.index', [
            'questions' => $questions,
            'subjects'  => Subject::all(),
        ]);
    }


    public function create()
    {
        $subjects = Subject::orderBy('name')->get();

        return view('admin.questions.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id'     => 'required|exists:subjects,id',
            'content'        => 'required|string',
            'weight'         => 'required|numeric|min:0.1',
            'correct_option' => 'required|integer',
            'options'        => 'required|array|min:2',
            'options.*.content' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {

            $question = Question::create([
                'subject_id' => $data['subject_id'],
                'content'    => $data['content'],
                'weight'     => $data['weight'],
                'status'     => 'draft',
            ]);

            foreach ($data['options'] as $idx => $opt) {
                if (empty(trim(strip_tags($opt['content'] ?? '')))) {
                    continue;
                }

                $question->options()->create([
                    'label'      => chr(65 + $idx),
                    'content'    => $opt['content'],
                    'is_correct' => ((int)$data['correct_option'] === $idx),
                ]);
            }
        });

        // === RESPONSE AJAX ===
        return response()->json([
            'success'  => true,
            'redirect' => route('admin.questions.index')
        ]);
    }

    public function edit(Question $question)
    {
        $question->load('options', 'subject');

        return view('admin.questions.edit', [
            'question' => $question,
            'subjects' => Subject::all()
        ]);
    }

    public function toggleStatus(Question $question)
    {
        $question->update([
            'status' => $question->status === 'published'
                ? 'draft'
                : 'published'
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
{
    $question = Question::with('options')->findOrFail($id);

    // ===============================
    // VALIDASI
    // ===============================
    $validated = $request->validate([
        'subject_id'                 => 'required|exists:subjects,id',
        'content'                    => 'required|string',
        'weight'                     => 'required|numeric|min:0.1',
        'correct_option'             => 'required|integer|min:0|max:4',
        'options'                    => 'required|array|size:5',
        'options.*.content'          => 'required|string',
    ]);

    DB::transaction(function () use ($validated, $question) {

        // ===============================
        // UPDATE QUESTION
        // ===============================
        $question->update([
            'subject_id' => $validated['subject_id'],
            'content'    => $validated['content'],
            'weight'     => $validated['weight'],
        ]);

        // ===============================
        // UPDATE OPTIONS
        // ===============================
        foreach ($validated['options'] as $index => $optData) {

            $option = $question->options[$index] ?? null;

            if ($option) {
                // update existing option
                $option->update([
                    'content'    => $optData['content'],
                    'is_correct' => ($index == $validated['correct_option']),
                ]);
            } else {
                // create if missing
                $question->options()->create([
                    'label'      => chr(65 + $index), // A, B, C, D, E
                    'content'    => $optData['content'],
                    'is_correct' => ($index == $validated['correct_option']),
                ]);
            }
        }
    });

    return redirect()
        ->route('admin.questions.index')
        ->with('success', 'Soal berhasil diperbarui.');
}

}
