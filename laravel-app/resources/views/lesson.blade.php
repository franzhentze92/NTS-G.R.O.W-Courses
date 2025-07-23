@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="max-width: 1400px;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 col-md-12">
            <!-- Elegant Header -->
            <div class="d-flex justify-content-between align-items-start mb-6">
                <div class="flex-1">
                    <a href="/courses/{{ $course->id }}" class="text-decoration-none mb-3 d-inline-block" style="color: #8cb33a; font-weight: 500; font-size: 0.9em;">
                        <i class="bi bi-arrow-left me-1"></i> Back to Course
                    </a>
                    <h1 class="mb-2" style="font-size: 2.2em; font-weight: bold; color: #101828;">{{ $lesson->title }}</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="/app/education/online-learning/courses" class="btn d-flex align-items-center gap-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                        <i class="bi bi-house"></i> All Courses
                    </a>
                </div>
            </div>

            <!-- Course Progress -->
            <div class="card shadow-sm border-0 mb-8" style="border-radius: 18px;">
                <div class="card-body p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-gray-900">Course Progress</span>
                        <span class="text-sm text-gray-600">
                            3 of 12 lessons completed
                        </span>
                    </div>
                    <div class="progress mb-2" style="height: 8px; border-radius: 4px; background-color: #f3f4f6;">
                        <div class="progress-bar" role="progressbar" style="width: 25%; background-color: #8cb33a; border-radius: 4px;"></div>
                    </div>
                    <p class="text-sm text-gray-600 mb-0 font-medium">25% complete</p>
                </div>
            </div>

            <!-- Spacer -->
            <div style="height: 2rem;"></div>

            <!-- Lesson Content -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-film" style="color: #8cb33a; font-size: 1.2em;"></i>
                            <h2 class="mb-0" style="font-size: 1.5em; font-weight: bold; color: #101828;">{{ $lesson->title }}</h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-clock" style="color: #667085;"></i>
                            <span style="color: #667085; font-size: 0.9em;">{{ $lesson->duration_minutes }} min</span>
                        </div>
                        <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $lesson->type }}</span>
                        <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.85em;">
                            <i class="bi bi-check-circle me-1"></i>Completed
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($lesson->type === 'video')
                        <!-- Video Player -->
                        <div class="mb-4">
                            <div class="ratio ratio-16x9" style="border-radius: 12px; overflow: hidden;">
                                <iframe src="{{ $lesson->content }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Lesson Content -->
                    <div class="mb-4">
                        <div style="color: #667085; line-height: 1.8; font-size: 1.1em; text-align: justify;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $lesson->content)) !!}
                        </div>
                    </div>

                    @if($lesson->type === 'quiz')
                        <!-- Quiz Section -->
                        <div class="mb-4">
                            <h4 style="color: #101828; font-weight: 600; margin-bottom: 1.5rem;">Quiz</h4>
                            <form id="quizForm">
                                @foreach($lesson->quizQuestions as $index => $question)
                                    <div class="mb-4 p-4" style="background: #f8fafc; border-radius: 12px;">
                                        <h5 class="mb-3" style="color: #101828; font-weight: 600;">Question {{ $index + 1 }}</h5>
                                        <p style="color: #667085; margin-bottom: 1.5rem;">{{ $question->question }}</p>
                                        
                                        <div class="options-container">
                                            @foreach($question->options as $optionIndex => $option)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_{{ $question->id }}_{{ $optionIndex }}" value="{{ $optionIndex }}">
                                                    <label class="form-check-label" for="option_{{ $question->id }}_{{ $optionIndex }}" style="color: #667085; cursor: pointer;">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn d-flex align-items-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                        <i class="bi bi-check-circle"></i> Submit Quiz
                                    </button>
                                    <button type="button" class="btn d-flex align-items-center gap-2" id="showAnswersBtn" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 1em;">
                                        <i class="bi bi-eye"></i> Show Answers
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Lesson Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                        <div class="d-flex gap-2">
                            @if($previousLesson)
                                <a href="/courses/{{ $course->id }}/lessons/{{ $previousLesson->id }}" class="btn d-flex align-items-center gap-2" style="background: transparent; color: #667085; border: 1px solid #d0d5dd; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                    <i class="bi bi-arrow-left"></i> Previous
                                </a>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button class="btn d-flex align-items-center gap-2" id="markCompleteBtn" style="background: #12B76A; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #12B76A; font-size: 0.9em;">
                                <i class="bi bi-check-circle"></i> Mark Complete
                            </button>
                        </div>
                        
                        <div class="d-flex gap-2">
                            @if($nextLesson)
                                <a href="/courses/{{ $course->id }}/lessons/{{ $nextLesson->id }}" class="btn d-flex align-items-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 0.9em;">
                                    Next <i class="bi bi-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm border-0" style="border-radius: 18px; position: sticky; top: 20px;">
                <div class="card-body p-4">
                    <h5 style="color: #101828; font-weight: 600; margin-bottom: 1.5rem;">
                        <i class="bi bi-list-ul me-2"></i>Course Lessons
                    </h5>
                    
                    <div class="lessons-list">
                        @foreach($chapters as $chapter)
                            <div class="chapter-section mb-3">
                                <h6 style="color: #8cb33a; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $chapter['title'] }}
                                </h6>
                                @foreach($chapter['lessons'] as $courseLesson)
                                    <a href="/courses/{{ $course->id }}/lessons/{{ $courseLesson->id }}" class="text-decoration-none">
                                        <div class="lesson-item mb-2 p-3 rounded cursor-pointer transition-all duration-200" 
                                             style="background: {{ $courseLesson->id === $lesson->id ? '#8cb33a' : '#ffffff' }}; 
                                                    border: 1px solid {{ $courseLesson->id === $lesson->id ? '#8cb33a' : '#e5e7eb' }};
                                                    {{ $courseLesson->id !== $lesson->id ? 'hover:bg-gray-50 hover:border-[#8cb33a]/30' : '' }};">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge" style="background: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#8cb33a' }}; color: {{ $courseLesson->id === $lesson->id ? '#8cb33a' : '#ffffff' }}; font-weight: 600; border-radius: 999px; font-size: 0.75em;">{{ $courseLesson->order }}</span>
                                                    <div>
                                                        <div style="font-weight: 600; color: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#101828' }}; font-size: 0.9em;">{{ $courseLesson->title }}</div>
                                                        <div style="color: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#667085' }}; font-size: 0.8em;">{{ $courseLesson->duration_minutes }} min • {{ $courseLesson->type }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    @if($courseLesson->id === $lesson->id)
                                                        <i class="bi bi-check-circle" style="color: #ffffff;"></i>
                                                    @else
                                                        <i class="bi bi-chevron-right" style="color: #8cb33a; font-size: 0.8em;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <!-- Course Progress -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">Course Progress</h6>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="color: #667085; font-size: 0.9em;">Progress</span>
                                <span style="color: #667085; font-size: 0.9em;">0%</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%; background-color: #8cb33a;"></div>
                            </div>
                        </div>
                        <small class="text-muted">0 of {{ $course->lessons_count }} lessons completed</small>
                    </div>

                    <!-- Course Info -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">Course Information</h6>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-clock" style="color: #8cb33a;"></i>
                            <span style="color: #667085; font-size: 0.9em;">{{ $course->duration_hours }} hours total</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-journal-text" style="color: #8cb33a;"></i>
                            <span style="color: #667085; font-size: 0.9em;">{{ $course->lessons_count }} lessons</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-person" style="color: #8cb33a;"></i>
                            <span style="color: #667085; font-size: 0.9em;">{{ $course->instructor ? $course->instructor->name : 'No instructor' }}</span>
                        </div>
                        @if($course->certification)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-award" style="color: #8cb33a;"></i>
                                <span style="color: #667085; font-size: 0.9em;">Certificate available</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let quizSubmitted = false;
    let userAnswers = {};

    // Quiz functionality
    $('#quizForm').on('submit', function(e) {
        e.preventDefault();
        
        if (quizSubmitted) {
            alert('Quiz already submitted!');
            return;
        }

        // Collect user answers
        $('input[type="radio"]:checked').each(function() {
            const questionId = $(this).attr('name').replace('question_', '');
            const answer = parseInt($(this).val());
            userAnswers[questionId] = answer;
        });

        // Check if all questions are answered
        const totalQuestions = {{ $lesson->quizQuestions->count() }};
        if (Object.keys(userAnswers).length < totalQuestions) {
            alert('Please answer all questions before submitting.');
            return;
        }

        // Calculate score
        let correctAnswers = 0;
        const questions = @json($lesson->quizQuestions);
        
        questions.forEach(question => {
            if (userAnswers[question.id] === question.correct_answer) {
                correctAnswers++;
            }
        });

        const score = Math.round((correctAnswers / totalQuestions) * 100);
        
        // Show results
        alert(`Quiz completed! Your score: ${score}% (${correctAnswers}/${totalQuestions} correct)`);
        
        quizSubmitted = true;
        $('#quizForm button[type="submit"]').prop('disabled', true).html('<i class="bi bi-check-circle"></i> Submitted');
    });

    // Show answers button
    $('#showAnswersBtn').on('click', function() {
        const questions = @json($lesson->quizQuestions);
        
        questions.forEach(question => {
            const questionElement = $(`input[name="question_${question.id}"]`).closest('.mb-4');
            const correctOption = questionElement.find(`input[value="${question.correct_answer}"]`);
            const correctLabel = correctOption.next('label');
            
            // Highlight correct answer
            correctLabel.css('color', '#12B76A').css('font-weight', '600');
            correctLabel.prepend('<i class="bi bi-check-circle-fill me-2" style="color: #12B76A;"></i>');
        });
    });

    // Mark complete functionality
    $('#markCompleteBtn').on('click', function() {
        const button = $(this);
        const originalText = button.html();
        
        button.html('<i class="bi bi-hourglass-split"></i> Marking...').prop('disabled', true);
        
        // Simulate API call to mark lesson as complete
        setTimeout(() => {
            button.html('<i class="bi bi-check-circle-fill"></i> Completed').css('background', '#12B76A');
            button.prop('disabled', true);
            
            // Update progress
            updateProgress();
        }, 1000);
    });

    // Update progress function
    function updateProgress() {
        // This would be calculated based on user's completed lessons
        const completedLessons = 0; // Get from user progress
        const totalLessons = {{ $course->lessons_count }};
        const progressPercentage = totalLessons > 0 ? (completedLessons / totalLessons) * 100 : 0;
        
        $('.progress-bar').css('width', progressPercentage + '%');
        $('.progress-bar').next().text(completedLessons + ' of ' + totalLessons + ' lessons completed');
    }

    // Initialize
    updateProgress();
});
</script>
@endsection 