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
        Schema::create('routine_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('time_of_day', ['pagi', 'malam']);
            $table->boolean('is_done')->default(false);
            $table->timestamps();

            // Prevent duplicate log entries for the same product/day/time
            $table->unique(['user_id', 'product_id', 'date', 'time_of_day'], 'unique_routine_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_logs');
    }
};
