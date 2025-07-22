@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Course Management</h1>
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button" role="tab">View All Courses</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab">Add New Course</button>
        </li>
    </ul>
    <div class="tab-content" id="adminTabContent">
        <!-- View All Courses Tab -->
        <div class="tab-pane fade show active" id="view" role="tabpanel">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Type</th>
                        <th>Lessons</th>
                        <th>Instructor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="adminCoursesList">
                    <!-- Courses will be rendered here by jQuery -->
                </tbody>
            </table>
        </div>
        <!-- Add New Course Tab -->
        <div class="tab-pane fade" id="add" role="tabpanel">
            <form id="addCourseForm">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="newCourseTitle" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-control" id="newCourseCategory">
                        <option value="Soil Health">Soil Health</option>
                        <option value="Plant Health">Plant Health</option>
                        <option value="Human Health">Human Health</option>
                        <option value="Animal Health">Animal Health</option>
                        <option value="Planetary Health">Planetary Health</option>
                        <option value="Crop Protection">Crop Protection</option>
                        <option value="Sustainable Practices">Sustainable Practices</option>
                        <option value="Technology">Technology</option>
                        <option value="Business & Marketing">Business & Marketing</option>
                        <option value="Innovation">Innovation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <select class="form-control" id="newCourseLevel">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select class="form-control" id="newCourseType">
                        <option value="Theory">Theory</option>
                        <option value="Practice">Practice</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Instructor</label>
                    <select class="form-control" id="newCourseInstructor"></select>
                </div>
                <button type="submit" class="btn btn-success">Add Course</button>
            </form>
        </div>
    </div>
</div>

<!-- Lesson Management Modal -->
<div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lessonModalLabel">Manage Lessons for <span id="modalCourseTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered align-middle mb-3">
          <thead class="table-light">
            <tr>
              <th>Order</th>
              <th>Title</th>
              <th>Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="lessonList">
            <!-- Lessons will be rendered here -->
          </tbody>
        </table>
        <form id="addLessonForm" class="row g-2 align-items-end">
          <div class="col-md-4">
            <input type="text" class="form-control" id="lessonTitleInput" placeholder="Lesson Title" required>
          </div>
          <div class="col-md-3">
            <select class="form-control" id="lessonTypeInput">
              <option value="Video">Video</option>
              <option value="Reading">Reading</option>
            </select>
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" id="lessonOrderInput" placeholder="Order" min="1" required>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-success w-100">Add Lesson</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Course Edit Modal -->
<div class="modal fade" id="courseEditModal" tabindex="-1" aria-labelledby="courseEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseEditModalLabel">Edit Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCourseForm">
          <input type="hidden" id="editCourseId">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" id="editCourseTitle" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-control" id="editCourseCategory">
              <option value="Soil Health">Soil Health</option>
              <option value="Plant Health">Plant Health</option>
              <option value="Human Health">Human Health</option>
              <option value="Animal Health">Animal Health</option>
              <option value="Planetary Health">Planetary Health</option>
              <option value="Crop Protection">Crop Protection</option>
              <option value="Sustainable Practices">Sustainable Practices</option>
              <option value="Technology">Technology</option>
              <option value="Business & Marketing">Business & Marketing</option>
              <option value="Innovation">Innovation</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Level</label>
            <select class="form-control" id="editCourseLevel">
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-control" id="editCourseType">
              <option value="Theory">Theory</option>
              <option value="Practice">Practice</option>
              <option value="Mixed">Mixed</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Instructor</label>
            <select class="form-control" id="editCourseInstructor"></select>
          </div>
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button" class="btn btn-secondary ms-2" id="manageLessonsBtn">Manage Lessons</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock data for admin courses
let adminCourses = [
    {
        id: 1,
        title: 'Introduction to Soil Health',
        category: 'Soil Health',
        level: 'Beginner',
        type: 'Theory',
        lessons: 8,
        instructor: 1
    },
    {
        id: 2,
        title: 'Advanced Plant Nutrition',
        category: 'Plant Health',
        level: 'Advanced',
        type: 'Practice',
        lessons: 12,
        instructor: 2
    },
];

// Add to adminCourses mock data: lessons array for each course
adminCourses.forEach(c => { if (!c.lessonsArr) c.lessonsArr = []; });

// Add instructors mock data (shared with instructor-management)
let instructors = [
    {
        id: 1,
        name: 'Dr. Jane Smith',
        title: 'Soil Scientist',
        email: 'jane.smith@example.com',
        website: 'https://example.com',
        location: 'Australia',
        bio: 'Dr. Smith has 20 years of experience in soil science and sustainable agriculture.'
    },
    {
        id: 2,
        name: 'Prof. John Doe',
        title: 'Plant Nutritionist',
        email: 'john.doe@example.com',
        website: 'https://example.org',
        location: 'USA',
        bio: 'Prof. Doe is an expert in plant nutrition and advanced growing techniques.'
    }
];

function renderAdminCourses() {
    const $list = $('#adminCoursesList');
    $list.empty();
    if (adminCourses.length === 0) {
        $list.append('<tr><td colspan="7" class="text-center">No courses found.</td></tr>');
        return;
    }
    adminCourses.forEach(course => {
        const instructorName = course.instructor ? (instructors.find(i => i.id === course.instructor)?.name || '') : '';
        $list.append(`
            <tr>
                <td>${course.title}</td>
                <td>${course.category}</td>
                <td>${course.level}</td>
                <td>${course.type}</td>
                <td>${course.lessons}</td>
                <td>${instructorName}</td>
                <td>
                    <button class="btn btn-sm btn-primary me-1 edit-course-btn" data-id="${course.id}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-course-btn" data-id="${course.id}">Delete</button>
                </td>
            </tr>
        `);
    });
}

$(document).ready(function() {
    populateInstructorDropdowns();
    renderAdminCourses();
    // Add new course
    $('#addCourseForm').on('submit', function(e) {
        e.preventDefault();
        const newCourse = {
            id: Date.now(),
            title: $('#newCourseTitle').val(),
            category: $('#newCourseCategory').val(),
            level: $('#newCourseLevel').val(),
            type: $('#newCourseType').val(),
            lessons: 0,
            instructor: $('#newCourseInstructor').val() ? parseInt($('#newCourseInstructor').val()) : null
        };
        adminCourses.push(newCourse);
        renderAdminCourses();
        this.reset();
        populateInstructorDropdowns();
        // Switch to view tab
        $('#view-tab').tab('show');
    });
    // Delete course
    $(document).on('click', '.delete-course-btn', function() {
        const id = $(this).data('id');
        adminCourses = adminCourses.filter(c => c.id !== id);
        renderAdminCourses();
    });
    // Edit course (open course edit modal)
    $(document).on('click', '.edit-course-btn', function() {
        const id = $(this).data('id');
        const course = adminCourses.find(c => c.id === id);
        $('#editCourseId').val(course.id);
        $('#editCourseTitle').val(course.title);
        $('#editCourseCategory').val(course.category);
        $('#editCourseLevel').val(course.level);
        $('#editCourseType').val(course.type);
        $('#editCourseInstructor').val(course.instructor);
        $('#courseEditModal').modal('show');
    });
    // Save course changes
    $('#editCourseForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        const id = parseInt($('#editCourseId').val());
        const course = adminCourses.find(c => c.id === id);
        course.title = $('#editCourseTitle').val();
        course.category = $('#editCourseCategory').val();
        course.level = $('#editCourseLevel').val();
        course.type = $('#editCourseType').val();
        course.instructor = $('#editCourseInstructor').val() ? parseInt($('#editCourseInstructor').val()) : null;
        renderAdminCourses();
        $('#courseEditModal').modal('hide');
    });
    // Manage lessons from course edit modal
    $('#manageLessonsBtn').off('click').on('click', function() {
        const id = parseInt($('#editCourseId').val());
        const course = adminCourses.find(c => c.id === id);
        $('#modalCourseTitle').text(course.title);
        $('#lessonModal').data('courseId', id).modal('show');
        renderLessonList(id);
    });
    // Render lessons in modal
    function renderLessonList(courseId) {
        const course = adminCourses.find(c => c.id === courseId);
        const $list = $('#lessonList');
        $list.empty();
        if (!course.lessonsArr.length) {
            $list.append('<tr><td colspan="4" class="text-center">No lessons yet.</td></tr>');
            return;
        }
        course.lessonsArr.sort((a, b) => a.order - b.order).forEach(lesson => {
            $list.append(`
                <tr>
                    <td>${lesson.order}</td>
                    <td>${lesson.title}</td>
                    <td>${lesson.type}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1 edit-lesson-btn" data-id="${lesson.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-lesson-btn" data-id="${lesson.id}">Delete</button>
                    </td>
                </tr>
            `);
        });
    }
    // Add lesson editing state
    let editingLessonId = null;
    // Edit lesson
    $(document).on('click', '.edit-lesson-btn', function() {
        const courseId = $('#lessonModal').data('courseId');
        const course = adminCourses.find(c => c.id === courseId);
        const lessonId = $(this).data('id');
        const lesson = course.lessonsArr.find(l => l.id === lessonId);
        if (lesson) {
            $('#lessonTitleInput').val(lesson.title);
            $('#lessonTypeInput').val(lesson.type);
            $('#lessonOrderInput').val(lesson.order);
            editingLessonId = lessonId;
            $('#addLessonForm button[type="submit"]').text('Save Changes');
        }
    });
    // Update addLessonForm submit to handle edit
    $('#addLessonForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        const courseId = $('#lessonModal').data('courseId');
        const course = adminCourses.find(c => c.id === courseId);
        if (editingLessonId) {
            // Edit existing lesson
            const lesson = course.lessonsArr.find(l => l.id === editingLessonId);
            if (lesson) {
                lesson.title = $('#lessonTitleInput').val();
                lesson.type = $('#lessonTypeInput').val();
                lesson.order = parseInt($('#lessonOrderInput').val());
            }
            editingLessonId = null;
            $('#addLessonForm button[type="submit"]').text('Add Lesson');
        } else {
            // Add new lesson
            const newLesson = {
                id: Date.now(),
                title: $('#lessonTitleInput').val(),
                type: $('#lessonTypeInput').val(),
                order: parseInt($('#lessonOrderInput').val())
            };
            course.lessonsArr.push(newLesson);
        }
        renderLessonList(courseId);
        this.reset();
    });
    // Reset form and editing state when modal closes
    $('#lessonModal').on('hidden.bs.modal', function () {
        editingLessonId = null;
        $('#addLessonForm')[0].reset();
        $('#addLessonForm button[type="submit"]').text('Add Lesson');
    });
});

// Populate instructor dropdowns
function populateInstructorDropdowns() {
    const options = instructors.map(i => `<option value="${i.id}">${i.name}</option>`).join('');
    $('#newCourseInstructor').html('<option value="">Select Instructor</option>' + options);
    $('#editCourseInstructor').html('<option value="">Select Instructor</option>' + options);
}
</script>
@endsection 