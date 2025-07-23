<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'level',
        'type',
        'instructor_id',
        'cover_image',
        'price',
        'status',
        'tags',
        'duration_hours',
        'lessons_count',
        'students_count',
        'rating',
        'featured',
        'certification'
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'featured' => 'boolean',
        'certification' => 'boolean',
        'duration_hours' => 'integer',
        'lessons_count' => 'integer',
        'students_count' => 'integer'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price == 0 ? 'Free' : '$' . number_format($this->price, 2);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'published' => 'success',
            'draft' => 'warning',
            'archived' => 'secondary',
            default => 'light'
        };
    }

    public function getCategoryColorAttribute()
    {
        $colorMap = [
            'soil-health' => 'brown',
            'plant-health' => 'success',
            'human-health' => 'danger',
            'animal-health' => 'warning',
            'planetary-health' => 'info',
            'crop-protection' => 'primary',
            'sustainable-practices' => 'success',
            'technology' => 'info',
            'business-marketing' => 'purple',
            'innovation' => 'warning'
        ];
        
        return $colorMap[$this->category] ?? 'light';
    }

    /**
     * Check if a user has completed all lessons in the course
     */
    public function isAllLessonsCompleted($userId)
    {
        $totalLessons = $this->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('is_completed', true)
            ->count();
        
        return $completedLessons >= $totalLessons;
    }

    /**
     * Check if the user has passed the final quiz with minimum 75% score
     */
    public function isQuizPassed($userId)
    {
        $finalQuiz = $this->lessons()->where('type', 'quiz')->orderBy('order', 'desc')->first();
        
        if (!$finalQuiz) {
            return false;
        }

        $quizProgress = LessonProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('lesson_id', $finalQuiz->id)
            ->where('is_completed', true)
            ->first();

        return $quizProgress && $quizProgress->quiz_score >= 75;
    }

    /**
     * Check if the course is completed (all lessons + quiz passed)
     */
    public function isCompleted($userId)
    {
        return $this->isAllLessonsCompleted($userId) && $this->isQuizPassed($userId);
    }

    /**
     * Get course completion percentage
     */
    public function getCompletionPercentage($userId)
    {
        $totalLessons = $this->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('is_completed', true)
            ->count();
        
        return $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
    }

    /**
     * Get the final quiz lesson
     */
    public function getFinalQuiz()
    {
        return $this->lessons()->where('type', 'quiz')->orderBy('order', 'desc')->first();
    }
}
