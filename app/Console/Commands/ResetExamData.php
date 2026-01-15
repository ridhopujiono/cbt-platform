<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetExamData extends Command
{
   protected $signature = 'exam:reset {--force : Skip confirmation}';

    protected $description = 'Reset data ujian (session, response, log) tanpa menghapus master data';

    public function handle(): int
    {
        if (! $this->option('force')) {
            if (! $this->confirm('Yakin ingin RESET semua data ujian? (session, response, log)')) {
                $this->info('Dibatalkan.');
                return self::SUCCESS;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('exam_logs')->truncate();
        DB::table('exam_responses')->truncate();
        DB::table('exam_sessions')->truncate();
        DB::table('exam_questions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('✔ Data ujian berhasil di-reset.');
        $this->line('Master data & seeder tetap aman.');

        return self::SUCCESS;
    }
}
