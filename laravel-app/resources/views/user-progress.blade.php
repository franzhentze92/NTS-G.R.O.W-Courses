@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">User Progress Tracking</h1>
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Enrolled Courses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userList">
                    <!-- Users will be rendered here by jQuery -->
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card d-none" id="progressCard">
                <div class="card-body">
                    <h5 id="progressUserName">User</h5>
                    <div id="progressDetails"></div>
                    <button class="btn btn-secondary mt-3" id="closeProgressBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock data for users, courses, and progress
const users = [
    { id: 1, name: 'Alice Green', email: 'alice@example.com' },
    { id: 2, name: 'Bob Brown', email: 'bob@example.com' }
];
const courses = [
    { id: 1, title: 'Introduction to Soil Health', lessons: 3 },
    { id: 2, title: 'Advanced Plant Nutrition', lessons: 4 }
];
const userProgress = [
    {
        userId: 1,
        enrollments: [
            { courseId: 1, completedLessons: 2, totalLessons: 3, lessonProgress: { 101: true, 102: true, 103: false } },
            { courseId: 2, completedLessons: 1, totalLessons: 4, lessonProgress: { 201: true, 202: false, 203: false, 204: false } }
        ]
    },
    {
        userId: 2,
        enrollments: [
            { courseId: 1, completedLessons: 3, totalLessons: 3, lessonProgress: { 101: true, 102: true, 103: true } }
        ]
    }
];
const lessons = {
    1: [
        { id: 101, title: 'What is Soil Health?' },
        { id: 102, title: 'Soil Structure' },
        { id: 103, title: 'Nutrients in Soil' }
    ],
    2: [
        { id: 201, title: 'Plant Nutrition Basics' },
        { id: 202, title: 'Macronutrients' },
        { id: 203, title: 'Micronutrients' },
        { id: 204, title: 'Advanced Techniques' }
    ]
};

function renderUsers() {
    const $list = $('#userList');
    $list.empty();
    users.forEach(user => {
        const progress = userProgress.find(up => up.userId === user.id);
        let enrolledCourses = '';
        if (progress && progress.enrollments.length) {
            enrolledCourses = progress.enrollments.map(enr => {
                const course = courses.find(c => c.id === enr.courseId);
                const percent = Math.round((enr.completedLessons / enr.totalLessons) * 100);
                return `${course.title} <span class='badge bg-info ms-1'>${percent}%</span>`;
            }).join('<br>');
        } else {
            enrolledCourses = '<span class="text-muted">None</span>';
        }
        $list.append(`
            <tr>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${enrolledCourses}</td>
                <td><button class="btn btn-sm btn-primary view-progress-btn" data-id="${user.id}">View Progress</button></td>
            </tr>
        `);
    });
}

function renderUserProgress(userId) {
    const user = users.find(u => u.id === userId);
    const progress = userProgress.find(up => up.userId === userId);
    $('#progressUserName').text(user.name);
    let html = '';
    if (progress && progress.enrollments.length) {
        progress.enrollments.forEach(enr => {
            const course = courses.find(c => c.id === enr.courseId);
            const percent = Math.round((enr.completedLessons / enr.totalLessons) * 100);
            html += `<div class='mb-3'><strong>${course.title}</strong><br>`;
            html += `<div class='progress mb-1'><div class='progress-bar' style='width:${percent}%;'>${percent}%</div></div>`;
            html += `<small>${enr.completedLessons} of ${enr.totalLessons} lessons completed</small>`;
            html += `<ul class='list-group mt-2'>`;
            lessons[course.id].forEach(lesson => {
                const done = enr.lessonProgress[lesson.id];
                html += `<li class='list-group-item d-flex justify-content-between align-items-center'>${lesson.title}<span>${done ? '<span class=\'badge bg-success\'>Done</span>' : '<span class=\'badge bg-secondary\'>Not done</span>'}</span></li>`;
            });
            html += `</ul></div>`;
        });
    } else {
        html = '<span class="text-muted">No enrollments.</span>';
    }
    $('#progressDetails').html(html);
    $('#progressCard').removeClass('d-none');
}

$(document).ready(function() {
    renderUsers();
    $(document).on('click', '.view-progress-btn', function() {
        const userId = parseInt($(this).data('id'));
        renderUserProgress(userId);
    });
    $('#closeProgressBtn').on('click', function() {
        $('#progressCard').addClass('d-none');
    });
});
</script>
@endsection 