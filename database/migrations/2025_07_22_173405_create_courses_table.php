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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('level')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->string('cover_image')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('status')->default('draft');
            $table->json('tags')->nullable();
            $table->integer('duration_hours')->default(2);
            $table->integer('lessons_count')->default(0);
            $table->integer('students_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('certification')->default(false);
            $table->timestamps();
            $table->foreign('instructor_id')->references('id')->on('instructors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
