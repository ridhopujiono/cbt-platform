<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExamResultExport;
use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use Maatwebsite\Excel\Facades\Excel;

class ExamResultExportController extends Controller
{
    public function export(ExamSchedule $schedule)
    {
        $filename = 'hasil-ujian-' .
            str()->slug($schedule->event->title) .
            '.xlsx';

        return Excel::download(
            new ExamResultExport($schedule),
            $filename
        );
    }
}
