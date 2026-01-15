<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
            UserSeeder::class,
            AdminUserSeeder::class,
            SubjectSeeder::class,
            PassageSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            ExamEventSeeder::class,
            ExamScheduleSeeder::class,
            ExamQuestionSeeder::class,
        ]);
    }
}
