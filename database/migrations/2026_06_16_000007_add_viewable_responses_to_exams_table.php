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
        Schema::table('Exams', function (Blueprint $table) {
            $table->boolean('viewable_responses')->default(false)->after('randomize_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Exams', function (Blueprint $table) {
            $table->dropColumn('viewable_responses');
        });
    }
};
