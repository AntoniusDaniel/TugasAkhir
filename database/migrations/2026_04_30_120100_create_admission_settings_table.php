<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admission_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('SD Negeri Semayu');
            $table->string('academic_year')->default('2026/2027');
            $table->unsignedInteger('quota')->default(28);
            $table->unsignedInteger('reserve_quota')->default(5);
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->boolean('is_registration_open')->default(true);
            $table->boolean('is_announcement_published')->default(false);
            $table->text('requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_settings');
    }
};
