<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('welcome');
});

// Course Catalog (Public)
Route::get('/courses', [CourseController::class, 'catalog']);

Route::get('/courses/{id}', [CourseController::class, 'show']);

// Lesson Page
Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'showLesson']);

// Admin Routes
Route::prefix('admin')->group(function () {
    // Course Management
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/course-create', [CourseController::class, 'create']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/course-edit/{id}', [CourseController::class, 'edit']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
    Route::patch('/courses/{id}/status', [CourseController::class, 'updateStatus']);
    Route::get('/courses-data', [CourseController::class, 'getCourses']);

    // Instructor Management
    Route::get('/instructors', function () {
        return view('instructor-management');
    });

    // User Progress
    Route::get('/user-progress', function () {
        return view('user-progress');
    });
});
