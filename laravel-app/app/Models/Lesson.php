<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'order',
        'content',
        'video_url',
        'document_url',
        'duration_minutes',
        'quiz_data',
        'is_locked'
    ];

    protected $casts = [
        'quiz_data' => 'array',
        'is_locked' => 'boolean',
        'duration_minutes' => 'integer',
        'order' => 'integer'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function getFormattedDurationAttribute()
    {
        return $this->duration_minutes . ' min';
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'video' => 'bi-camera-video',
            'quiz' => 'bi-question-circle',
            'reading' => 'bi-book',
            default => 'bi-file-text'
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'video' => 'primary',
            'quiz' => 'warning',
            'reading' => 'success',
            default => 'secondary'
        };
    }
}
