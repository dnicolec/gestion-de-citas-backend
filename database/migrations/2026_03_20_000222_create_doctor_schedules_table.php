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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->unique(['user_id', 'day_of_week', 'start_time', 'end_time'], 'unique_schedule_block');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
