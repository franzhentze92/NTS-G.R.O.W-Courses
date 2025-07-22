@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="/courses" class="btn d-flex align-items-center gap-2 mb-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                        <i class="bi bi-arrow-left"></i> Back to Courses
                    </a>
                    <h1 class="mb-0" style="font-size: 2.2em; font-weight: bold; color: #101828;">Soil Science Fundamentals</h1>
                    <p class="text-muted mb-0" style="font-size: 1.1em;">Master the basics of soil science and sustainable agriculture</p>
                </div>
            </div>
            <!-- Hero/Header Section -->
            <div class="mb-4">
                <div class="mb-2 d-flex align-items-center gap-2">
                    <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 1em;" id="courseCategory"><i class="bi bi-leaf me-1"></i>Soil Health</span>
                    <span class="badge" style="background: #D1FADF; color: #12B76A; font-weight: 500; border-radius: 999px; font-size: 1em;" id="courseLevel"><i class="bi bi-bar-chart me-1"></i>Beginner</span>
                    <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 1em;" id="courseType"><i class="bi bi-lightbulb me-1"></i>Theory</span>
                </div>
                <h1 class="fw-bold mb-2" id="courseTitle" style="font-size: 2.2rem; color: #101828;">Course Title</h1>
                <div class="d-flex align-items-center gap-4 text-muted mb-2" style="font-size: 1.1em;">
                    <span><i class="bi bi-clock me-1"></i> <span id="courseDuration">2h 30m</span></span>
                    <span><i class="bi bi-journal-text me-1"></i> <span id="courseLessons">8 lessons</span></span>
                    <span><i class="bi bi-calendar me-1"></i> <span id="courseUpdated">Updated 2024-06-01</span></span>
                </div>
                <div class="mb-2" id="progressBarSection" style="display: none;">
                    <label class="mb-1">Course Progress</label>
                    <div class="progress mb-1" style="height: 10px; background: #eaf5d3;">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%; background: #8cb33a;">0%</div>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 1em;">
                        <span id="progressText">0 of 0 lessons completed</span>
                        <span id="progressPercent">0%</span>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="courseTabs" role="tablist" style="--bs-nav-tabs-link-active-border-color: #8cb33a;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" style="color: #8cb33a; border-color: #8cb33a; font-weight: 600; background: #fff;"> <i class="bi bi-info-circle me-1"></i>Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum" type="button" role="tab" style="color: #344054; font-weight: 600; background: #fff;"> <i class="bi bi-list-check me-1"></i>Curriculum</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor" type="button" role="tab" style="color: #344054; font-weight: 600; background: #fff;"> <i class="bi bi-person-badge me-1"></i>Instructor</button>
                </li>
            </ul>
            <div class="tab-content" id="courseTabContent">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <h4 class="mb-3">About This Course</h4>
                    <p id="courseLongDescription">Long description goes here.</p>
                    <h5 class="mt-4 mb-2">What You'll Learn</h5>
                    <ul id="learningObjectives"></ul>
                    <h5 class="mt-4 mb-2">Prerequisites</h5>
                    <ul id="prerequisites"></ul>
                    <div id="courseTags" class="mt-3"></div>
                </div>
                <div class="tab-pane fade" id="curriculum" role="tabpanel">
                    <h4 class="mb-3">Course Curriculum</h4>
                    <div id="lessonsList"></div>
                </div>
                <div class="tab-pane fade" id="instructor" role="tabpanel">
                    <h4 class="mb-3">Instructor</h4>
                    <div id="instructorInfo"></div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 2rem;">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="mb-3">
                        <img id="sidebarImage" src="/how-to-thumbnails-languages/grow-courses.jpeg" alt="Course image" class="w-100 rounded-3 mb-3" style="object-fit: cover; height: 160px;">
                        <span class="fw-bold fs-3" id="coursePrice">Free</span>
                        <div class="text-muted small" id="coursePriceDesc">No payment required</div>
                    </div>
                    <button class="btn w-100 d-flex align-items-center justify-content-center gap-2 mb-3" id="enrollBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1.1em;">
                        <i class="bi bi-play-fill"></i> Continue Learning
                    </button>
                    <hr>
                    <div class="mb-2 text-muted">Course includes:</div>
                    <ul class="list-unstyled mb-0" style="font-size: 1em;">
                        <li class="mb-2"><i class="bi bi-journal-text me-2 text-success"></i> <span id="sidebarLessons">8 lessons</span></li>
                        <li class="mb-2"><i class="bi bi-clock me-2 text-success"></i> <span id="sidebarDuration">2h 30m of content</span></li>
                        <li class="mb-2"><i class="bi bi-chat-dots me-2 text-success"></i> Instructor support</li>
                        <li class="mb-2"><i class="bi bi-globe me-2 text-success"></i> Full lifetime access</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mock Data and jQuery Logic -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock course data
const mockCourse = {
    id: 1,
    title: 'Soil Therapy Workshop – Understanding your Soil Test & DIY Nutrition Programming',
    description: 'A practical workshop on soil therapy and nutrition programming.',
    long_description: 'This course covers the fundamentals of soil health, soil testing, and how to create your own nutrition program for crops.',
    category: 'Soil Health',
    level: 'Beginner',
    type: 'Theory',
    lessons: [
        { id: 101, title: 'Chapter 1 Introduction – Unlocking the Hidden Language of Your Soil', description: '', type: 'reading', order: 1, duration: '5 min', is_locked: false, is_completed: true },
        { id: 102, title: 'Watch the Video', description: '', type: 'video', order: 2, duration: '21 min', is_locked: false, is_completed: true },
        { id: 103, title: 'Detailed Summary', description: '', type: 'reading', order: 3, duration: '5 min', is_locked: false, is_completed: true },
        { id: 104, title: 'Chapter 2 Introduction – Turning Numbers into Knowledge', description: '', type: 'reading', order: 4, duration: '21 min', is_locked: false, is_completed: false },
        { id: 105, title: 'Watch the Video', description: '', type: 'video', order: 5, duration: '21 min', is_locked: false, is_completed: false },
    ],
    duration: '2 hours',
    updated_at: '2025-07-06',
    learning_objectives: ['Understand soil basics', 'Perform soil tests', 'Create nutrition programs'],
    prerequisites: ['Basic biology knowledge'],
    tags: ['soil', 'nutrition', 'workshop'],
    instructor: {
        name: 'Graeme Sait',
        title: 'Soil Health Expert',
        bio: 'Graeme Sait is an internationally recognized educator in soil health and sustainable agriculture.',
        avatar: 'https://randomuser.me/api/portraits/men/45.jpg',
        location: 'Australia',
        experience: '30+ years',
        specializations: ['Soil Health', 'Nutrition', 'Workshops']
    },
    price: 0,
    image: '/how-to-thumbnails-languages/grow-courses.jpeg'
};

function renderCourseDetail() {
    $('#courseCategory').html('<i class="bi bi-leaf me-1"></i>' + mockCourse.category);
    $('#courseLevel').html('<i class="bi bi-bar-chart me-1"></i>' + mockCourse.level);
    $('#courseType').html('<i class="bi bi-lightbulb me-1"></i>' + mockCourse.type);
    $('#courseTitle').text(mockCourse.title);
    $('#courseDescription').text(mockCourse.description);
    $('#courseDuration').text(mockCourse.duration);
    $('#courseLessons').text(`${mockCourse.lessons.length} lessons`);
    $('#courseUpdated').text(`Updated ${mockCourse.updated_at}`);
    $('#coursePrice').text(mockCourse.price === 0 ? 'Free' : '$' + mockCourse.price);
    $('#coursePriceDesc').text(mockCourse.price === 0 ? 'No payment required' : 'One-time payment');
    $('#sidebarLessons').text(`${mockCourse.lessons.length} lessons`);
    $('#sidebarDuration').text(`${mockCourse.duration} of content`);
    $('#sidebarImage').attr('src', mockCourse.image);
    $('#courseLongDescription').text(mockCourse.long_description);
    // Progress bar
    const completed = mockCourse.lessons.filter(l => l.is_completed).length;
    const percent = Math.round((completed / mockCourse.lessons.length) * 100);
    if (completed > 0) {
        $('#progressBarSection').show();
        $('#progressBar').css('width', percent + '%').text(percent + '%');
        $('#progressText').text(`${completed} of ${mockCourse.lessons.length} lessons completed`);
        $('#progressPercent').text(percent + '%');
    } else {
        $('#progressBarSection').hide();
    }
    // Learning objectives
    $('#learningObjectives').empty();
    mockCourse.learning_objectives.forEach(obj => $('#learningObjectives').append(`<li class='mb-1'><i class='bi bi-check-circle-fill text-success me-2'></i>${obj}</li>`));
    // Prerequisites
    $('#prerequisites').empty();
    mockCourse.prerequisites.forEach(pr => $('#prerequisites').append(`<li class='mb-1'><i class='bi bi-dot text-secondary me-2'></i>${pr}</li>`));
    // Tags
    $('#courseTags').empty();
    mockCourse.tags.forEach(tag => $('#courseTags').append(`<span class="badge bg-outline-secondary me-1">${tag}</span>`));
    // Instructor
    $('#instructorInfo').html(`
        <div class="d-flex align-items-center mb-3">
            <img src="${mockCourse.instructor.avatar}" class="rounded-circle me-3" width="80" height="80" alt="Instructor">
            <div>
                <h5><i class="bi bi-person-badge me-1"></i>${mockCourse.instructor.name}</h5>
                <p class="mb-1"><i class="bi bi-award me-1"></i>${mockCourse.instructor.title}</p>
                <small><i class="bi bi-geo-alt me-1"></i>${mockCourse.instructor.location}</small>
            </div>
        </div>
        <p>${mockCourse.instructor.bio}</p>
        <p><i class="bi bi-hourglass-split me-1"></i><strong>Experience:</strong> ${mockCourse.instructor.experience}</p>
        <div><i class="bi bi-stars me-1"></i><strong>Specializations:</strong> ${mockCourse.instructor.specializations.join(', ')}</div>
    `);
    // Lessons
    renderLessons();
}

function renderLessons() {
    let html = '';
    mockCourse.lessons.forEach((lesson, idx) => {
        const isCompleted = lesson.is_completed;
        const lessonUrl = `/courses/1/lessons/${lesson.id}`;
        html += `<div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 ${isCompleted ? '' : 'bg-white'}" style="border: 1px solid #e5e7eb; background: ${isCompleted ? '#eaf5d3' : '#fff'};">
            <div class="d-flex align-items-center gap-2">
                <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 1em;">Lesson ${lesson.order}</span>
                <span style="font-weight: 600; color: #101828;">${lesson.title}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge" style="background: #fff; color: #101828; font-weight: 600; border-radius: 8px; font-size: 1em; border: 1px solid #e5e7eb;">${lesson.duration}</span>
                <span class="badge" style="background: #fff; color: #101828; font-weight: 600; border-radius: 8px; font-size: 1em; border: 1px solid #e5e7eb;"><i class="bi bi-${lesson.type === 'video' ? 'camera-video' : 'book'} me-1"></i>${lesson.type}</span>
                <a href="${lessonUrl}" class="btn btn-sm d-flex align-items-center gap-1" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">${isCompleted ? '<i class=\'bi bi-arrow-repeat\'></i> Review' : '<i class=\'bi bi-play-fill\'></i> Start'}</a>
            </div>
        </div>`;
    });
    $('#lessonsList').html(html);
}

$(document).ready(function() {
    renderCourseDetail();
    // Tabs
    $('#courseTabs button').on('click', function() {
        $('#courseTabs button').removeClass('active').css('color', '#344054').css('border-color', '#fff').css('background', '#fff');
        $(this).addClass('active').css('color', '#8cb33a').css('border-color', '#8cb33a').css('background', '#fff');
        $('.tab-pane').removeClass('show active');
        $($(this).data('bs-target')).addClass('show active');
    });
    // In renderCourseDetail, update sidebar button to link to first incomplete lesson
    $('#enrollBtn').off('click').on('click', function() {
        const firstIncomplete = mockCourse.lessons.find(l => !l.is_completed) || mockCourse.lessons[0];
        window.location.href = `/courses/1/lessons/${firstIncomplete.id}`;
    });
});
</script>
@endsection
