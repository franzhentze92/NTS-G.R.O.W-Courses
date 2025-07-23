<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'question',
        'options',
        'correct_answer',
        'order'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'integer',
        'order' => 'integer'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getCorrectAnswerTextAttribute()
    {
        return $this->options[$this->correct_answer] ?? '';
    }

    public function getOptionLabelAttribute($index)
    {
        $labels = ['A', 'B', 'C', 'D'];
        return $labels[$index] ?? '';
    }
} 