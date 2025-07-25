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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->integer('order')->default(1);
            $table->longText('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('document_url')->nullable();
            $table->integer('duration_minutes')->default(5);
            $table->json('quiz_data')->nullable(); // For quiz questions and answers
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
