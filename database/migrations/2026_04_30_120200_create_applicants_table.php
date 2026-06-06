<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('student_name');
            $table->string('nisn')->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion')->nullable();
            $table->text('address');
            $table->string('previous_school');
            $table->string('parent_name');
            $table->string('parent_phone', 30);
            $table->string('parent_email')->nullable();
            $table->string('birth_certificate_path');
            $table->string('family_card_path');
            $table->string('photo_path');
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('selection_status', ['waiting', 'accepted', 'reserve', 'rejected'])->default('waiting');
            $table->text('verification_note')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
