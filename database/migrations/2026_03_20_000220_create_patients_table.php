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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('given_name');
            $table->string('family_name');
            $table->string('id_document')->unique()->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['masculino', 'femenino', 'otro']);
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->text('home_address');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
