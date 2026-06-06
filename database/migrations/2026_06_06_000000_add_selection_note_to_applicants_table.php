<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table): void {
            $table->text('selection_note')->nullable()->after('selection_status');
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table): void {
            $table->dropColumn('selection_note');
        });
    }
};
