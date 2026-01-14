<?php

namespace Database\Seeders;

use App\Models\Passage;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $subject = Subject::first();
        $passage = Passage::first();

        $questions = [
            'Hasil dari 2 + 3 × 4 adalah …',
            'Nilai dari 12 ÷ (3 + 1) adalah …',
            'Jika x = 5, maka nilai dari 2x + 3 adalah …',
            'Keliling persegi dengan sisi 6 cm adalah …',
            'Luas persegi dengan sisi 4 cm adalah …',
        ];

        foreach ($questions as $text) {
            Question::create([
                'passage_id' => $passage->id,
                'subject_id' => $subject->id,
                'content' => $text,
                'weight' => 1.0,
                'status' => 'published',
            ]);
        }
    }
}
