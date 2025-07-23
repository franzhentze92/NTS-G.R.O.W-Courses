@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="max-width: 1400px;">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="/admin/courses" class="btn d-flex align-items-center gap-2 mb-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                        <i class="bi bi-arrow-left"></i> Back to Course Management
                    </a>
                    <h1 class="mb-0" style="font-size: 2.2em; font-weight: bold; color: #101828;">Create New Course</h1>
                    <p class="text-muted mb-0" style="font-size: 1.1em;">Add a new course to your learning platform</p>
                </div>
            </div>

            <!-- Course Creation Form -->
            <form id="courseForm">
                @csrf
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                            <div class="card-body p-4">
                                <h4 class="mb-3" style="color: #101828; font-weight: 600;">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h4>
                                
                                <div class="mb-3">
                                    <label for="courseTitle" class="form-label" style="font-weight: 600; color: #344054;">Course Title *</label>
                                    <input type="text" class="form-control" id="courseTitle" name="title" placeholder="Enter course title" required>
                                </div>

                                <div class="mb-3">
                                    <label for="courseDescription" class="form-label" style="font-weight: 600; color: #344054;">Course Description *</label>
                                    <textarea class="form-control" id="courseDescription" name="description" rows="4" placeholder="Describe what students will learn in this course" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="courseCategory" class="form-label" style="font-weight: 600; color: #344054;">Category *</label>
                                        <select class="form-select" id="courseCategory" name="category" required>
                                            <option value="">Select category</option>
                                            <option value="soil-health">Soil Health</option>
                                            <option value="plant-health">Plant Health</option>
                                            <option value="human-health">Human Health</option>
                                            <option value="animal-health">Animal Health</option>
                                            <option value="planetary-health">Planetary Health</option>
                                            <option value="crop-protection">Crop Protection</option>
                                            <option value="sustainable-practices">Sustainable Practices</option>
                                            <option value="technology">Technology</option>
                                            <option value="business-marketing">Business & Marketing</option>
                                            <option value="innovation">Innovation</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="courseLevel" class="form-label" style="font-weight: 600; color: #344054;">Level *</label>
                                        <select class="form-select" id="courseLevel" name="level" required>
                                            <option value="">Select level</option>
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="courseType" class="form-label" style="font-weight: 600; color: #344054;">Type *</label>
                                        <select class="form-select" id="courseType" name="type" required>
                                            <option value="">Select type</option>
                                            <option value="theory">Theory</option>
                                            <option value="practice">Practice</option>
                                            <option value="mixed">Mixed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="coursePrice" class="form-label" style="font-weight: 600; color: #344054;">Price ($)</label>
                                        <input type="number" class="form-control" id="coursePrice" name="price" placeholder="0 for free" min="0" value="0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="courseImage" class="form-label" style="font-weight: 600; color: #344054;">Course Image URL</label>
                                    <input type="url" class="form-control" id="courseImage" name="cover_image" placeholder="https://example.com/image.jpg">
                                </div>

                                <div class="mb-3">
                                    <label for="courseTags" class="form-label" style="font-weight: 600; color: #344054;">Tags (comma separated)</label>
                                    <input type="text" class="form-control" id="courseTags" name="tags" placeholder="soil, agriculture, sustainability">
                                </div>
                            </div>
                        </div>

                        <!-- Course Settings -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                            <div class="card-body p-4">
                                <h4 class="mb-3" style="color: #101828; font-weight: 600;">
                                    <i class="bi bi-gear me-2"></i>Course Settings
                                </h4>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="courseStatus" class="form-label" style="font-weight: 600; color: #344054;">Status *</label>
                                        <select class="form-select" id="courseStatus" name="status" required>
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="courseInstructor" class="form-label" style="font-weight: 600; color: #344054;">Instructor</label>
                                        <select class="form-select" id="courseInstructor" name="instructor_id">
                                            <option value="">Select instructor</option>
                                            @foreach($instructors as $instructor)
                                                <option value="{{ $instructor->id }}">{{ $instructor->name }} - {{ $instructor->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="courseDuration" class="form-label" style="font-weight: 600; color: #344054;">Estimated Duration (hours)</label>
                                        <input type="number" class="form-control" id="courseDuration" name="duration_hours" placeholder="2" min="0" value="2">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="courseLessons" class="form-label" style="font-weight: 600; color: #344054;">Number of Lessons</label>
                                        <input type="number" class="form-control" id="courseLessons" placeholder="5" min="1" value="5" readonly>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="courseFeatured" name="featured" value="1">
                                    <label class="form-check-label" for="courseFeatured" style="font-weight: 500; color: #344054;">
                                        Featured Course
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="courseCertification" name="certification" value="1">
                                    <label class="form-check-label" for="courseCertification" style="font-weight: 500; color: #344054;">
                                        Offer Certificate
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Lesson Management -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0" style="color: #101828; font-weight: 600;">
                                        <i class="bi bi-list-ul me-2"></i>Course Lessons
                                    </h4>
                                    <button type="button" class="btn d-flex align-items-center gap-2" id="addLessonBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 0.9em;">
                                        <i class="bi bi-plus-circle"></i> Add Lesson
                                    </button>
                                </div>

                                <div id="lessonsList">
                                    <!-- Lessons will be added here dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Sidebar -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0" style="border-radius: 18px; position: sticky; top: 20px;">
                            <div class="card-body p-4">
                                <h5 class="mb-3" style="color: #101828; font-weight: 600;">
                                    <i class="bi bi-eye me-2"></i>Course Preview
                                </h5>
                                
                                <div id="coursePreview">
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle" style="font-size: 2em; color: #d0d5dd;"></i>
                                        <p class="mt-2">Fill in the course details to see a preview</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-column gap-2 mt-4 pt-3 border-top">
                                    <button type="submit" class="btn d-flex align-items-center justify-content-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                        <i class="bi bi-check-circle"></i> Create Course
                                    </button>
                                    <button type="button" class="btn d-flex align-items-center justify-content-center gap-2" id="saveDraftBtn" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 1em;">
                                        <i class="bi bi-save"></i> Save as Draft
                                    </button>
                                    <a href="/admin/courses" class="btn d-flex align-items-center justify-content-center gap-2" style="background: transparent; color: #667085; border: 1px solid #d0d5dd; border-radius: 8px; font-weight: 600; font-size: 1em;">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lesson Modal -->
<div class="modal fade" id="lessonModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lessonModalTitle">Add New Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="lessonForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lessonTitle" class="form-label" style="font-weight: 600; color: #344054;">Lesson Title *</label>
                            <input type="text" class="form-control" id="lessonTitle" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lessonType" class="form-label" style="font-weight: 600; color: #344054;">Lesson Type *</label>
                            <select class="form-select" id="lessonType" required>
                                <option value="">Select type</option>
                                <option value="reading">Reading</option>
                                <option value="video">Video</option>
                                <option value="quiz">Quiz</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lessonDuration" class="form-label" style="font-weight: 600; color: #344054;">Duration (minutes)</label>
                        <input type="number" class="form-control" id="lessonDuration" min="1" value="5">
                    </div>

                    <div class="mb-3">
                        <label for="lessonContent" class="form-label" style="font-weight: 600; color: #344054;">Content *</label>
                        <textarea class="form-control" id="lessonContent" rows="4" placeholder="Enter lesson content..."></textarea>
                    </div>

                    <!-- Quiz Section (hidden by default) -->
                    <div id="quizSection" style="display: none;">
                        <h6 class="mb-3" style="color: #101828; font-weight: 600;">Quiz Questions</h6>
                        <div id="quizQuestions">
                            <!-- Quiz questions will be added here -->
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addQuestionBtn">
                            <i class="bi bi-plus-circle"></i> Add Question
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" id="saveLessonBtn" style="background: #8cb33a; color: #fff; border: 1px solid #8cb33a;">Save Lesson</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let lessons = [];
    let currentLessonIndex = -1;

    // Initialize lesson counter
    function updateLessonCount() {
        $('#courseLessons').val(lessons.length);
    }

    // Show/hide quiz section based on lesson type
    $('#lessonType').on('change', function() {
        if ($(this).val() === 'quiz') {
            $('#quizSection').show();
        } else {
            $('#quizSection').hide();
        }
    });

    // Add question to quiz
    $('#addQuestionBtn').on('click', function() {
        const questionIndex = $('#quizQuestions .question-item').length;
        const questionHtml = `
            <div class="question-item mb-3 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Question ${questionIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question" data-question="${questionIndex}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <input type="text" class="form-control question-text" placeholder="Enter question...">
                </div>
                <div class="mb-2">
                    <label class="form-label">Options</label>
                    <div class="options-container">
                        <div class="input-group mb-2">
                            <span class="input-group-text">A</span>
                            <input type="text" class="form-control option-text" placeholder="Option A">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="correct_${questionIndex}" value="0">
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text">B</span>
                            <input type="text" class="form-control option-text" placeholder="Option B">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="correct_${questionIndex}" value="1">
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text">C</span>
                            <input type="text" class="form-control option-text" placeholder="Option C">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="correct_${questionIndex}" value="2">
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text">D</span>
                            <input type="text" class="form-control option-text" placeholder="Option D">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="correct_${questionIndex}" value="3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#quizQuestions').append(questionHtml);
    });

    // Remove question
    $(document).on('click', '.remove-question', function() {
        $(this).closest('.question-item').remove();
        // Renumber questions
        $('#quizQuestions .question-item').each(function(index) {
            $(this).find('h6').text(`Question ${index + 1}`);
        });
    });

    // Add lesson button
    $('#addLessonBtn').on('click', function() {
        currentLessonIndex = -1;
        $('#lessonModalTitle').text('Add New Lesson');
        $('#lessonForm')[0].reset();
        $('#quizSection').hide();
        $('#quizQuestions').empty();
        $('#lessonModal').modal('show');
    });

    // Save lesson
    $('#saveLessonBtn').on('click', function() {
        const lessonData = {
            title: $('#lessonTitle').val(),
            type: $('#lessonType').val(),
            duration: $('#lessonDuration').val(),
            content: $('#lessonContent').val(),
            order: lessons.length + 1
        };

        if (!lessonData.title || !lessonData.type || !lessonData.content) {
            alert('Please fill in all required fields.');
            return;
        }

        // Handle quiz data
        if (lessonData.type === 'quiz') {
            const questions = [];
            $('#quizQuestions .question-item').each(function() {
                const questionText = $(this).find('.question-text').val();
                const options = [];
                $(this).find('.option-text').each(function() {
                    options.push($(this).val());
                });
                const correctAnswer = $(this).find('input[type="radio"]:checked').val();
                
                if (questionText && options.every(opt => opt) && correctAnswer !== undefined) {
                    questions.push({
                        question: questionText,
                        options: options,
                        correct: parseInt(correctAnswer)
                    });
                }
            });
            lessonData.questions = questions;
        }

        if (currentLessonIndex === -1) {
            // Add new lesson
            lessons.push(lessonData);
        } else {
            // Edit existing lesson
            lessons[currentLessonIndex] = lessonData;
        }

        renderLessons();
        updateLessonCount();
        $('#lessonModal').modal('hide');
    });

    // Render lessons
    function renderLessons() {
        const lessonsList = $('#lessonsList');
        lessonsList.empty();

        if (lessons.length === 0) {
            lessonsList.html(`
                <div class="text-center text-muted py-4">
                    <i class="bi bi-list-ul" style="font-size: 2em; color: #d0d5dd;"></i>
                    <p class="mt-2">No lessons added yet. Click "Add Lesson" to get started.</p>
                </div>
            `);
            return;
        }

        lessons.forEach((lesson, index) => {
            const lessonCard = `
                <div class="card mb-3 border-0" style="background: #f8fafc; border-radius: 12px;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.8em;">Lesson ${lesson.order}</span>
                                    <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.8em;">${lesson.type}</span>
                                    <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.8em;">${lesson.duration} min</span>
                                </div>
                                <h6 class="mb-1" style="font-weight: 600; color: #101828;">${lesson.title}</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.9em;">${lesson.content.substring(0, 100)}${lesson.content.length > 100 ? '...' : ''}</p>
                                ${lesson.type === 'quiz' && lesson.questions ? `<small class="text-muted">${lesson.questions.length} questions</small>` : ''}
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm edit-lesson" data-index="${index}" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm delete-lesson" data-index="${index}" style="background: transparent; color: #F04438; border: 1px solid #F04438;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            lessonsList.append(lessonCard);
        });
    }

    // Edit lesson
    $(document).on('click', '.edit-lesson', function() {
        const index = $(this).data('index');
        const lesson = lessons[index];
        currentLessonIndex = index;
        
        $('#lessonModalTitle').text('Edit Lesson');
        $('#lessonTitle').val(lesson.title);
        $('#lessonType').val(lesson.type);
        $('#lessonDuration').val(lesson.duration);
        $('#lessonContent').val(lesson.content);
        
        if (lesson.type === 'quiz') {
            $('#quizSection').show();
            $('#quizQuestions').empty();
            if (lesson.questions) {
                lesson.questions.forEach((q, qIndex) => {
                    $('#addQuestionBtn').click();
                    const questionItem = $('#quizQuestions .question-item').last();
                    questionItem.find('.question-text').val(q.question);
                    questionItem.find('.option-text').each(function(optIndex) {
                        $(this).val(q.options[optIndex]);
                    });
                    questionItem.find(`input[value="${q.correct}"]`).prop('checked', true);
                });
            }
        } else {
            $('#quizSection').hide();
        }
        
        $('#lessonModal').modal('show');
    });

    // Delete lesson
    $(document).on('click', '.delete-lesson', function() {
        const index = $(this).data('index');
        if (confirm('Are you sure you want to delete this lesson?')) {
            lessons.splice(index, 1);
            // Renumber lessons
            lessons.forEach((lesson, idx) => {
                lesson.order = idx + 1;
            });
            renderLessons();
            updateLessonCount();
        }
    });

    // Form submission with AJAX
    $('#courseForm').on('submit', function(e) {
        e.preventDefault();
        
        if (lessons.length === 0) {
            alert('Please add at least one lesson to the course.');
            return;
        }
        
        // Collect form data
        const formData = new FormData(this);
        
        // Add lessons data
        formData.append('lessons', JSON.stringify(lessons));
        
        // Add tags as array
        const tags = $('#courseTags').val().split(',').map(tag => tag.trim()).filter(tag => tag);
        formData.append('tags', JSON.stringify(tags));
        
        // Add boolean fields
        formData.append('featured', $('#courseFeatured').is(':checked') ? 1 : 0);
        formData.append('certification', $('#courseCertification').is(':checked') ? 1 : 0);

        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="bi bi-hourglass-split"></i> Creating...').prop('disabled', true);

        // Submit via AJAX
        $.ajax({
            url: '/admin/courses',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Course created successfully!');
                    window.location.href = '/admin/courses';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while creating the course.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = 'Please check the form and try again.';
                }
                alert(errorMessage);
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Save as draft
    $('#saveDraftBtn').on('click', function() {
        $('#courseStatus').val('draft');
        $('#courseForm').submit();
    });

    // Auto-save draft every 30 seconds
    let autoSaveTimer;
    $('input, textarea, select').on('change', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            console.log('Auto-saving draft...');
            // Implement auto-save functionality here
        }, 30000);
    });

    // Initialize
    updateLessonCount();
});
</script>
@endsection 