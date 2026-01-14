<?php

namespace Database\Seeders;

use App\Models\ExamEvent;
use Illuminate\Database\Seeder;

class ExamEventSeeder extends Seeder
{
    public function run(): void
    {
        ExamEvent::create([
            'title' => 'TKA Matematika Internal',
            'description' => 'Ujian internal instansi',
        ]);
    }
}
