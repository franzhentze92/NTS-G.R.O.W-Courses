<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('avatar')->nullable();
            $table->json('specializations')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('location')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
}; 