<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;

Route::get('/', function () {
    return view('welcome');
});

// Course Catalog (Public)
Route::get('/courses', [CourseController::class, 'catalog']);

Route::get('/courses/{id}', [CourseController::class, 'show']);

// Lesson Page
Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show']);

// Mark lesson as complete
Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'markComplete'])->name('lesson.complete');

// Quiz submission
Route::post('/courses/{course}/lessons/{lesson}/quiz', [LessonController::class, 'submitQuiz'])->name('lesson.quiz');

// Get perfect quiz scores
Route::get('/perfect-quiz-scores', [LessonController::class, 'getPerfectQuizScores'])->name('perfect.quiz.scores');

// Get perfect course completions
Route::get('/perfect-course-completions', [LessonController::class, 'getPerfectCourseCompletions'])->name('perfect.course.completions');

// Display perfect quiz scores page
Route::get('/perfect-scores', function () {
    return view('perfect-quiz-scores');
})->name('perfect.scores.page');

// Display perfect course completions page
Route::get('/course-completions', function () {
    return view('perfect-quiz-scores');
})->name('course.completions.page');

// Test route for quiz questions
Route::get('/test/quiz-questions/{lessonId}', function($lessonId) {
    $questions = \App\Models\QuizQuestion::where('lesson_id', $lessonId)->orderBy('order')->get();
    return response()->json($questions);
});

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
