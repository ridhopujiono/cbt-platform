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
        Schema::create('exam_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('session_id')->constrained('exam_sessions')->cascadeOnDelete();
            $table->string('event_type');
            $table->text('log_data')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_logs');
    }
};
