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
        Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'medico', 'asistente'])->default('asistente')->after('email');
        $table->string('phone_number')->after('role');
        $table->string('medical_specialty')->nullable()->after('phone_number');
        $table->boolean('is_active')->default(true)->after('medical_specialty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone_number', 'medical_specialty', 'is_active']);
        });
    }
};
