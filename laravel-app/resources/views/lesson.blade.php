@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: transparent;">
    <div class="container" style="max-width: 1400px;">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="/courses/1" class="btn d-flex align-items-center gap-2 mb-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                            <i class="bi bi-arrow-left"></i> Back to Course
                        </a>
                        <h1 class="mb-0" style="font-size: 2.2em; font-weight: bold; color: #101828;">Soil Science Fundamentals</h1>
                        <p class="text-muted mb-0" style="font-size: 1.1em;">Master the basics of soil science and sustainable agriculture</p>
                    </div>
                </div>
                <!-- Progress Bar and Stats -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-bold" id="lessonCourseTitle">Course Title</div>
                        <div class="text-muted" id="lessonProgressText">0 of 0 lessons completed</div>
                    </div>
                    <div class="progress mb-2" style="height: 10px; background: #eaf5d3;">
                        <div class="progress-bar" id="lessonProgressBar" role="progressbar" style="width: 0%; background: #8cb33a;">0%</div>
                    </div>
                </div>
                <!-- Lesson Content -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="mb-3">
                        <h2 class="fw-bold mb-1" id="lessonTitle">Lesson Title</h2>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 1em;" id="lessonOrder">Lesson 1</span>
                            <span class="badge" style="background: #fff; color: #101828; font-weight: 600; border-radius: 8px; font-size: 1em; border: 1px solid #e5e7eb;" id="lessonDuration">10 min</span>
                            <span class="badge" style="background: #fff; color: #101828; font-weight: 600; border-radius: 8px; font-size: 1em; border: 1px solid #e5e7eb;" id="lessonType"><i class="bi bi-book me-1"></i>reading</span>
                        </div>
                    </div>
                    <div id="lessonContent" class="mb-4">
                        <!-- Video or reading content will be rendered here -->
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn d-flex align-items-center gap-2" id="prevLessonBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                            <i class="bi bi-arrow-left-circle"></i> Previous
                        </button>
                        <button class="btn d-flex align-items-center gap-2" id="markCompleteBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                            <i class="bi bi-check-circle"></i> Mark as Complete
                        </button>
                        <button class="btn d-flex align-items-center gap-2" id="continueBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                            <i class="bi bi-arrow-right-circle"></i> Continue
                        </button>
                    </div>
                    <div id="lessonCompleteMsg" class="alert alert-success mt-3" style="display:none;">Lesson marked as completed!</div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 2rem;">
                    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                        <div class="fw-bold mb-3">Lesson List</div>
                        <ul class="list-unstyled mb-0" id="allLessonsList"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mock Data and jQuery Logic -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const mockCourse = {
    id: 1,
    title: 'Soil Therapy Workshop – Understanding your Soil Test & DIY Nutrition Programming',
    lessons: [
        { id: 101, title: 'Chapter 1 Introduction – Unlocking the Hidden Language of Your Soil', type: 'reading', order: 1, duration: '5 min', content: '<p>Welcome to the course! This is a reading lesson.</p>', is_completed: true },
        { id: 102, title: 'Watch the Video', type: 'video', order: 2, duration: '21 min', content: '<video width="100%" controls><source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">Your browser does not support the video tag.</video>', is_completed: true },
        { id: 103, title: 'Detailed Summary', type: 'reading', order: 3, duration: '5 min', content: '<p>This is a summary reading lesson.</p>', is_completed: true },
        { id: 104, title: 'Chapter 2 Introduction – Turning Numbers into Knowledge', type: 'reading', order: 4, duration: '21 min', content: '<p>Another reading lesson.</p>', is_completed: false },
        { id: 105, title: 'Watch the Video', type: 'video', order: 5, duration: '21 min', content: '<video width="100%" controls><source src="https://www.w3schools.com/html/movie.mp4" type="video/mp4">Your browser does not support the video tag.</video>', is_completed: false },
    ]
};

let currentLessonIndex = 0;

function renderLesson(idx) {
    const lesson = mockCourse.lessons[idx];
    $('#lessonTitle').text(lesson.title);
    $('#lessonOrder').text('Lesson ' + lesson.order);
    $('#lessonDuration').text(lesson.duration);
    $('#lessonType').html(`<i class="bi bi-${lesson.type === 'video' ? 'camera-video' : 'book'} me-1"></i>${lesson.type}`);
    $('#lessonContent').html(lesson.content);
    // Mark as complete button state
    if (lesson.is_completed) {
        $('#markCompleteBtn').prop('disabled', true).html('<i class="bi bi-check-circle"></i> Completed');
        $('#lessonCompleteMsg').show();
    } else {
        $('#markCompleteBtn').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Mark as Complete');
        $('#lessonCompleteMsg').hide();
    }
    // Continue button state
    $('#continueBtn').prop('disabled', idx === mockCourse.lessons.length - 1);
    // Previous button state
    $('#prevLessonBtn').prop('disabled', idx === 0);
}

function renderProgress() {
    const completed = mockCourse.lessons.filter(l => l.is_completed).length;
    const percent = Math.round((completed / mockCourse.lessons.length) * 100);
    $('#lessonCourseTitle').text(mockCourse.title);
    $('#lessonProgressBar').css('width', percent + '%').text(percent + '%');
    $('#lessonProgressText').text(`${completed} of ${mockCourse.lessons.length} lessons completed`);
}

function renderAllLessons(idx) {
    $('#allLessonsList').empty();
    mockCourse.lessons.forEach((lesson, i) => {
        const isCurrent = i === idx;
        const isCompleted = lesson.is_completed;
        $('#allLessonsList').append(`
            <li class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 ${isCompleted ? 'bg-success bg-opacity-10' : isCurrent ? 'bg-light border border-success' : 'bg-light'}" style="border: 1px solid #e5e7eb; cursor: pointer;" data-lesson-index="${i}">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.8em;">Lesson ${lesson.order}</span>
                    <span style="font-weight: 600; color: #101828; font-size: 0.9em;">${lesson.title}</span>
                    ${isCompleted ? '<i class="bi bi-check-circle-fill text-success ms-2"></i>' : ''}
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge" style="background: #fff; color: #101828; font-weight: 600; border-radius: 8px; font-size: 0.75em; border: 1px solid #e5e7eb;"><i class="bi bi-${lesson.type === 'video' ? 'camera-video' : 'book'} me-1"></i>${lesson.type}</span>
                </div>
            </li>
        `);
    });
}

$(document).ready(function() {
    renderLesson(currentLessonIndex);
    renderProgress();
    renderAllLessons(currentLessonIndex);
    // Mark as complete
    $('#markCompleteBtn').on('click', function() {
        const lesson = mockCourse.lessons[currentLessonIndex];
        if (!lesson.is_completed) {
            lesson.is_completed = true;
            renderLesson(currentLessonIndex);
            renderProgress();
            renderAllLessons(currentLessonIndex);
            $('#lessonCompleteMsg').show();
        }
    });
    // Continue button
    $('#continueBtn').on('click', function() {
        if (currentLessonIndex < mockCourse.lessons.length - 1) {
            currentLessonIndex++;
            renderLesson(currentLessonIndex);
            renderAllLessons(currentLessonIndex);
        }
    });
    // Previous button
    $('#prevLessonBtn').on('click', function() {
        if (currentLessonIndex > 0) {
            currentLessonIndex--;
            renderLesson(currentLessonIndex);
            renderAllLessons(currentLessonIndex);
        }
    });
    
    // Sidebar lesson navigation
    $(document).on('click', '#allLessonsList li', function() {
        const lessonIndex = $(this).data('lesson-index');
        currentLessonIndex = lessonIndex;
        renderLesson(currentLessonIndex);
        renderAllLessons(currentLessonIndex);
    });
});
</script>
@endsection 