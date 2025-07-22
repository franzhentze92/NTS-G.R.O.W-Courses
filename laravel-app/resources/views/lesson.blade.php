@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="/courses/1" class="btn btn-link mb-3">&larr; Back to Course</a>
    <div class="row">
        <div class="col-lg-8">
            <h2 id="lessonTitle">Lesson Title</h2>
            <div class="mb-2">
                <span class="badge bg-primary" id="lessonType">Type</span>
                <span class="badge bg-secondary" id="lessonOrder">Order</span>
            </div>
            <p id="lessonDescription">Lesson description goes here.</p>
            <div id="lessonContent" class="mb-4">
                <!-- Video or reading content will be rendered here -->
            </div>
            <button class="btn btn-success mb-3" id="markCompleteBtn">Mark as Complete</button>
            <div class="d-flex justify-content-between">
                <button class="btn btn-outline-secondary" id="prevLessonBtn">&larr; Previous Lesson</button>
                <button class="btn btn-outline-secondary" id="nextLessonBtn">Next Lesson &rarr;</button>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Course Progress</h5>
                    <div class="progress mb-2">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%">0%</div>
                    </div>
                    <small id="progressText">0 of 0 lessons completed</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>All Lessons</h5>
                    <ul class="list-group" id="allLessonsList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock course and lessons data
const mockCourse = {
    id: 1,
    lessons: [
        { id: 101, title: 'What is Soil Health?', description: 'Overview of soil health.', type: 'Video', order: 1, content: '<video width="100%" controls><source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">Your browser does not support the video tag.</video>' },
        { id: 102, title: 'Soil Structure', description: 'Understanding soil structure.', type: 'Reading', order: 2, content: '<p>This lesson covers the structure of soil and its importance for plant growth.</p>' },
        { id: 103, title: 'Nutrients in Soil', description: 'Key nutrients and their roles.', type: 'Video', order: 3, content: '<video width="100%" controls><source src="https://www.w3schools.com/html/movie.mp4" type="video/mp4">Your browser does not support the video tag.</video>' },
    ]
};

// Get lesson index from URL (simulate /courses/1/lessons/101)
const urlParts = window.location.pathname.split('/');
const lessonId = parseInt(urlParts[urlParts.length - 1]);
const currentLessonIndex = mockCourse.lessons.findIndex(l => l.id === lessonId) !== -1 ? mockCourse.lessons.findIndex(l => l.id === lessonId) : 0;

function getProgress() {
    return JSON.parse(localStorage.getItem('course-progress-' + mockCourse.id) || '{"completedLessons":0,"totalLessons":' + mockCourse.lessons.length + ',"lessonProgress":{}}');
}
function setProgress(progress) {
    localStorage.setItem('course-progress-' + mockCourse.id, JSON.stringify(progress));
}

function renderLesson(idx) {
    const lesson = mockCourse.lessons[idx];
    $('#lessonTitle').text(lesson.title);
    $('#lessonType').text(lesson.type);
    $('#lessonOrder').text('Lesson ' + lesson.order);
    $('#lessonDescription').text(lesson.description);
    $('#lessonContent').html(lesson.content);
    // Mark as complete button state
    const progress = getProgress();
    if (progress.lessonProgress[lesson.id]) {
        $('#markCompleteBtn').prop('disabled', true).text('Completed');
    } else {
        $('#markCompleteBtn').prop('disabled', false).text('Mark as Complete');
    }
    // Prev/Next buttons
    $('#prevLessonBtn').prop('disabled', idx === 0);
    $('#nextLessonBtn').prop('disabled', idx === mockCourse.lessons.length - 1);
}

function renderProgress() {
    const progress = getProgress();
    const percent = Math.round((progress.completedLessons / progress.totalLessons) * 100);
    $('#progressBar').css('width', percent + '%').text(percent + '%');
    $('#progressText').text(`${progress.completedLessons} of ${progress.totalLessons} lessons completed`);
}

function renderAllLessons(idx) {
    const progress = getProgress();
    $('#allLessonsList').empty();
    mockCourse.lessons.forEach((lesson, i) => {
        const isCurrent = i === idx;
        const isCompleted = progress.lessonProgress[lesson.id];
        $('#allLessonsList').append(`
            <li class="list-group-item d-flex justify-content-between align-items-center ${isCurrent ? 'active' : ''}">
                <span>${lesson.title}</span>
                <span>${isCompleted ? '<span class=\'badge bg-success\'>Completed</span>' : ''}</span>
            </li>
        `);
    });
}

$(document).ready(function() {
    let idx = currentLessonIndex;
    renderLesson(idx);
    renderProgress();
    renderAllLessons(idx);
    // Mark as complete
    $('#markCompleteBtn').on('click', function() {
        const lesson = mockCourse.lessons[idx];
        const progress = getProgress();
        if (!progress.lessonProgress[lesson.id]) {
            progress.lessonProgress[lesson.id] = true;
            progress.completedLessons = Object.keys(progress.lessonProgress).length;
            setProgress(progress);
            renderLesson(idx);
            renderProgress();
            renderAllLessons(idx);
            alert('Lesson marked as complete (demo).');
        }
    });
    // Prev/Next navigation
    $('#prevLessonBtn').on('click', function() {
        if (idx > 0) {
            idx--;
            history.replaceState(null, '', `/courses/1/lessons/${mockCourse.lessons[idx].id}`);
            renderLesson(idx);
            renderAllLessons(idx);
        }
    });
    $('#nextLessonBtn').on('click', function() {
        if (idx < mockCourse.lessons.length - 1) {
            idx++;
            history.replaceState(null, '', `/courses/1/lessons/${mockCourse.lessons[idx].id}`);
            renderLesson(idx);
            renderAllLessons(idx);
        }
    });
});
</script>
@endsection 