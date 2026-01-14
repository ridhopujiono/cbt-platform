<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        $optionsMap = [
            ['A' => '14', 'B' => '20', 'C' => '24', 'D' => '10', 'correct' => 'A'],
            ['A' => '1', 'B' => '3', 'C' => '4', 'D' => '6', 'correct' => 'C'],
            ['A' => '10', 'B' => '13', 'C' => '15', 'D' => '8', 'correct' => 'B'],
            ['A' => '12', 'B' => '24', 'C' => '36', 'D' => '48', 'correct' => 'B'],
            ['A' => '8', 'B' => '12', 'C' => '16', 'D' => '20', 'correct' => 'C'],
        ];

        $questions = Question::all();

        foreach ($questions as $index => $question) {
            foreach (['A', 'B', 'C', 'D'] as $label) {
                Option::create([
                    'question_id' => $question->id,
                    'label' => $label,
                    'content' => $optionsMap[$index][$label],
                    'is_correct' => $optionsMap[$index]['correct'] === $label,
                ]);
            }
        }
    }
}
