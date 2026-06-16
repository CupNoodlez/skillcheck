<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Options', function (Blueprint $table) {
            $table->uuid('option_id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('question_id');
            $table->integer('order_index');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);

            $table->foreign('question_id')->references('question_id')->on('Questions')->onDelete('cascade');
            $table->unique(['question_id', 'order_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Options');
    }
};
