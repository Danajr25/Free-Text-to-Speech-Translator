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
        Schema::create('translation_histories', function (Blueprint $table) {
            $table->id();
            $table->text('source_text');
            $table->text('translated_text');
            $table->string('source_language')->default('en');
            $table->string('target_language');
            $table->string('audio_path')->nullable();
            $table->string('voice_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_histories');
    }
};
