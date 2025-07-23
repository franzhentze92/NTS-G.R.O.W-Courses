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
}
