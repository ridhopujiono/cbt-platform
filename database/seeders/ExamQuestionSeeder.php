<?php

namespace Database\Seeders;

use App\Models\ExamQuestion;
use App\Models\ExamSchedule;
use App\Models\Question;
use Illuminate\Database\Seeder;

class ExamQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $schedule = ExamSchedule::first();
        $questions = Question::all();

        foreach ($questions as $i => $question) {
            ExamQuestion::create([
                'schedule_id' => $schedule->id,
                'question_id' => $question->id,
                'order_number' => $i + 1,
            ]);
        }
    }
}
