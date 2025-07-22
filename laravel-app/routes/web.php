<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/courses', function () {
    return view('courses');
});

Route::get('/courses/{id}', function ($id) {
    // For now, just return the mock course detail view
    return view('course-detail');
});

Route::get('/courses/{course}/lessons/{lesson}', function ($course, $lesson) {
    // For now, just return the mock lesson view
    return view('lesson');
});

Route::get('/admin/courses', function () {
    return view('course-management');
});

Route::get('/admin/instructors', function () {
    return view('instructor-management');
});

Route::get('/admin/user-progress', function () {
    return view('user-progress');
});
