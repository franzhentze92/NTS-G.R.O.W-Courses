<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'bio',
        'email',
        'website',
        'avatar',
        'specializations',
        'experience_years',
        'location',
        'social_links'
    ];

    protected $casts = [
        'specializations' => 'array',
        'social_links' => 'array',
        'experience_years' => 'integer'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
} 