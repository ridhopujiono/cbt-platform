<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_sessions', function ($table) {
            $table->float('score')->nullable();

            $table->integer('correct_count')->default(0);
            $table->float('raw_score')->default(0);
            $table->float('final_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->dropColumn('score');

            $table->dropColumn('correct_count');
            $table->dropColumn('raw_score');
            $table->dropColumn('final_score');
        });
    }
};
