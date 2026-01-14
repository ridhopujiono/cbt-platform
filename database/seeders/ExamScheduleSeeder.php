<?php

namespace Database\Seeders;

use App\Models\ExamEvent;
use App\Models\ExamSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExamScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $event = ExamEvent::first();

        ExamSchedule::create([
            'event_id' => $event->id,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addHours(2),
            'duration_minutes' => 60,
        ]);
    }
}
