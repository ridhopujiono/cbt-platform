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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passage_id')->nullable()->constrained('passages')->nullOnDelete();
            $table->foreignId('subject_id')->constrained('subjects');
            $table->text('content');
            $table->float('weight')->default(1.0);
            $table->enum('status', ['draft', 'review', 'published']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
