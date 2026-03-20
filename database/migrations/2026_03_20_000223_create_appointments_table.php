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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['programada', 'completada', 'cancelada'])->default('programada');
            $table->text('visit_reason');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id', 'appointment_date', 'start_time'], 'unique_appointment_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
