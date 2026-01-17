<?php

namespace App\Exports;

use App\Models\ExamSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExamResultExport implements FromCollection, WithHeadings
{
    protected ExamSchedule $schedule;

    public function __construct(ExamSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function collection(): Collection
    {
        return $this->schedule->sessions()
            ->with('user')
            ->where('status', 'finished')
            ->get()
            ->map(function ($session) {
                return [
                    'username'       => $session->user->username,
                    'correct_count'  => $session->correct_count,
                    'raw_score'      => $session->raw_score,
                    'final_score'    => $session->final_score,
                    'start_time'     => $session->start_time,
                    'end_time'       => $session->end_time,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Username',
            'Jawaban Benar',
            'Skor Bobot',
            'Nilai Akhir',
            'Waktu Mulai',
            'Waktu Selesai',
        ];
    }
}
