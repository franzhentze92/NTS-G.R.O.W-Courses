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
                    <a href="/courses" class="btn d-flex align-items-center gap-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
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
                            {{ $completedLessons }} of {{ $totalLessons }} lessons completed
                        </span>
                    </div>
                    <div class="progress mb-2" style="height: 8px; border-radius: 4px; background-color: #f3f4f6;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%; background-color: #8cb33a; border-radius: 4px;"></div>
                    </div>
                    <p class="text-sm text-gray-600 mb-0 font-medium">{{ $progressPercentage }}% complete</p>
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
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-clock" style="color: #667085;"></i>
                            <span style="color: #667085; font-size: 0.9em;">{{ $lesson->duration_minutes }} min</span>
                        </div>
                        <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $lesson->type }}</span>
                        @if($lesson->type === 'quiz' && $userProgress)
                            @if($userProgress->is_completed && $userProgress->quiz_score >= 75)
                                <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.85em;">
                                    <i class="bi bi-check-circle me-1"></i>Passed
                                </span>
                            @elseif($userProgress->quiz_score !== null)
                                <span class="badge" style="background: #FEC84B; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.85em;">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Failed
                                </span>
                            @endif
                        @elseif($userProgress && $userProgress->is_completed)
                            <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.85em;">
                                <i class="bi bi-check-circle me-1"></i>Completed
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($lesson->type === 'video')
                        <!-- Video Player -->
                        <div class="mb-4">
                            <div class="ratio ratio-16x9" style="border-radius: 12px; overflow: hidden; background: #000; position: relative;">
                                @if(str_contains($lesson->content, 'drive.google.com') && str_contains($lesson->content, 'preview'))
                                    <!-- Google Drive Video Embed -->
                                    <iframe src="{{ $lesson->content }}"
                                            title="{{ $lesson->title }}"
                                            style="width: 100%; height: 100%; border: none;"
                                            frameborder="0"
                                            allow="autoplay; fullscreen">
                                    </iframe>
                                @elseif(str_contains($lesson->content, '/videos/'))
                                    <!-- Direct Video File -->
                                    <video controls controlsList="nodownload" style="width: 100%; height: 100%; object-fit: cover;">
                                        <source src="{{ $lesson->content }}" type="video/mp4">
                                        <source src="{{ $lesson->content }}" type="video/webm">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <!-- Direct Video File -->
                                    <video controls style="width: 100%; height: 100%; object-fit: cover;">
                                        <source src="{{ $lesson->content }}" type="video/mp4">
                                        <source src="{{ $lesson->content }}" type="video/webm">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Lesson Content -->
                    @if($lesson->type !== 'video')
                        <div class="mb-4">
                            <div style="color: #667085; line-height: 1.8; font-size: 1.1em; text-align: justify;">
                                {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $lesson->content)) !!}
                            </div>
                        </div>
                    @endif

                    @if($lesson->type === 'quiz')
                        <!-- Quiz Section -->
                        <div class="mb-4">
                            <h4 style="color: #101828; font-weight: 600; margin-bottom: 1.5rem;">Quiz</h4>
                            
                            <!-- Quiz Form (shown initially) -->
                            <form id="quizForm">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between text-sm text-muted">
                                        <span id="questionCount">{{ count($lesson->quizQuestions) }} questions</span>
                                        <span id="timeElapsed">Time: 0s</span>
                                    </div>
                                </div>
                                
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
                                    <button type="submit" class="btn d-flex align-items-center gap-2" id="submitQuizBtn" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                        <i class="bi bi-check-circle"></i> Submit Quiz
                                    </button>
                                    <button type="button" class="btn d-flex align-items-center gap-2" id="showAnswersBtn" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 1em;">
                                        <i class="bi bi-eye"></i> Show Answers
                                    </button>
                                </div>
                                
                                <div id="submitMessage" class="mt-3 text-center" style="display: none;">
                                    <p class="text-muted">Please answer all questions before submitting</p>
                                </div>
                            </form>
                            
                            <!-- Quiz Results (hidden initially) -->
                            <div id="quizResults" style="display: none;">
                                <div class="text-center mb-4">
                                    <div id="resultIcon" class="mb-3"></div>
                                    <h3 class="mb-3" style="color: #101828; font-weight: 600;">Quiz Complete!</h3>
                                    
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #f0f9ff;">
                                                <div id="correctCount" class="h4 mb-1 text-primary">0</div>
                                                <div class="text-sm text-primary">Correct</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #fef2f2;">
                                                <div id="incorrectCount" class="h4 mb-1 text-danger">0</div>
                                                <div class="text-sm text-danger">Incorrect</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div id="scorePercentage" class="display-4 text-success mb-2">0%</div>
                                        <div id="scoreMessage" class="text-muted"></div>
                                    </div>
                                    
                                    <div class="text-sm text-muted mb-4">
                                        Time taken: <span id="finalTime">0</span> seconds
                                    </div>
                                    
                                    <button type="button" class="btn btn-outline-primary" id="retakeQuizBtn">
                                        <i class="bi bi-arrow-clockwise"></i> Retake Quiz
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Lesson Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-4 border-top lesson-actions">
                        <div class="d-flex gap-2">
                            @if($previousLesson)
                                <a href="/courses/{{ $course->id }}/lessons/{{ $previousLesson->id }}" class="btn d-flex align-items-center gap-2" style="background: transparent; color: #667085; border: 1px solid #d0d5dd; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                    <i class="bi bi-arrow-left"></i> Previous
                                </a>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-2">
                            @if($lesson->type === 'quiz')
                                @if($userProgress && $userProgress->is_completed && $userProgress->quiz_score >= 75)
                                    <button class="btn d-flex align-items-center gap-2" disabled style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 0.9em;">
                                        <i class="bi bi-check-circle"></i> Quiz Passed
                                    </button>
                                @elseif($userProgress && $userProgress->quiz_score !== null)
                                    <button class="btn d-flex align-items-center gap-2" disabled style="background: #FEC84B; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #FEC84B; font-size: 0.9em;">
                                        <i class="bi bi-exclamation-triangle"></i> Quiz Failed
                                    </button>
                                @else
                                    <div class="text-muted small">Complete the quiz to mark as finished</div>
                                @endif
                            @elseif($userProgress && $userProgress->is_completed)
                                <button class="btn d-flex align-items-center gap-2" disabled style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 0.9em;">
                                    <i class="bi bi-check-circle"></i> Completed
                                </button>
                            @else
                                <button class="btn d-flex align-items-center gap-2" id="markCompleteBtn" style="background: #12B76A; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #12B76A; font-size: 0.9em;">
                                    <i class="bi bi-check-circle"></i> Mark Complete
                                </button>
                            @endif
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
                        @php $lessonCounter = 1; @endphp
                        @foreach($chapters as $chapter)
                            <div class="chapter-section mb-3">
                                <h6 style="color: #8cb33a; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $chapter['title'] }}
                                </h6>
                                @foreach($chapter['lessons'] as $courseLesson)
                                    <a href="/courses/{{ $course->id }}/lessons/{{ $courseLesson->id }}" class="text-decoration-none">
                                        <div class="lesson-item mb-2 p-3 rounded cursor-pointer transition-all duration-200" 
                                             style="background: {{ $courseLesson->id === $lesson->id ? '#8cb33a' : (in_array($courseLesson->id, $lessonProgress) ? '#e8f5e8' : '#ffffff') }}; 
                                                    border: 1px solid {{ $courseLesson->id === $lesson->id ? '#8cb33a' : (in_array($courseLesson->id, $lessonProgress) ? '#8cb33a' : '#e5e7eb') }};
                                                    {{ $courseLesson->id !== $lesson->id ? 'hover:bg-gray-50 hover:border-[#8cb33a]/30' : '' }};">
                                            
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge" style="background: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#8cb33a' }}; color: {{ $courseLesson->id === $lesson->id ? '#8cb33a' : '#ffffff' }}; font-weight: 600; border-radius: 999px; font-size: 0.75em;">{{ $lessonCounter }}</span>
                                                <div>
                                                    <div style="font-weight: 600; color: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#101828' }}; font-size: 0.9em;">{{ $courseLesson->title }}</div>
                                                    <div style="color: {{ $courseLesson->id === $lesson->id ? '#ffffff' : '#667085' }}; font-size: 0.8em;">{{ $courseLesson->duration_minutes }} min • {{ $courseLesson->type }}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                @if($courseLesson->id === $lesson->id)
                                                    <i class="bi bi-chevron-right" style="color: #ffffff; font-size: 0.8em;"></i>
                                                @elseif(in_array($courseLesson->id, $lessonProgress))
                                                    <i class="bi bi-check-circle" style="color: #8cb33a;"></i>
                                                @else
                                                    <i class="bi bi-chevron-right" style="color: #8cb33a; font-size: 0.8em;"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    @php $lessonCounter++; @endphp
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
                                <span style="color: #667085; font-size: 0.9em;">{{ $progressPercentage }}%</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%; background-color: #8cb33a;"></div>
                            </div>
                        </div>
                        <small class="text-muted">{{ $completedLessons }} of {{ $totalLessons }} lessons completed</small>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Test if jQuery is loaded
if (typeof $ === 'undefined') {
    console.error('jQuery is not loaded!');
    alert('jQuery is not loaded. Please refresh the page.');
} else {
    console.log('jQuery is loaded successfully!');
}

$(document).ready(function() {
    console.log('Document ready - initializing quiz functionality');
    
    let quizStartTime = new Date();
    let timeInterval;
    let quizSubmitted = false;
    
    // Quiz functionality
    if ($('#quizForm').length > 0) {
        console.log('Quiz form found, initializing...');
        
        const totalQuestions = {{ count($lesson->quizQuestions) }};
        const questions = @json($lesson->quizQuestions);
        
        console.log('Total questions:', totalQuestions);
        console.log('Questions data:', questions);
        
        // Start timer
        function startTimer() {
            console.log('Starting timer...');
            timeInterval = setInterval(function() {
                const elapsed = Math.floor((new Date() - quizStartTime) / 1000);
                $('#timeElapsed').text('Time: ' + elapsed + 's');
            }, 1000);
        }
        
        // Check if all questions are answered
        function checkAllAnswered() {
            const answeredCount = $('input[type="radio"]:checked').length;
            const allAnswered = answeredCount === totalQuestions;
            
            console.log('Answered questions:', answeredCount, 'of', totalQuestions);
            
            $('#submitQuizBtn').prop('disabled', !allAnswered);
            $('#submitMessage').toggle(!allAnswered);
            
            return allAnswered;
        }
        
        // Calculate score
        function calculateScore() {
            console.log('Calculating score...');
            let correctAnswers = 0;
            const answers = {};
            
            questions.forEach(function(question) {
                const selectedAnswer = $(`input[name="question_${question.id}"]:checked`).val();
                console.log(`Question ${question.id}: selected=${selectedAnswer}, correct=${question.correct_answer}`);
                
                if (selectedAnswer !== undefined) {
                    answers[question.id] = parseInt(selectedAnswer);
                    if (parseInt(selectedAnswer) === question.correct_answer) {
                        correctAnswers++;
                    }
                }
            });
            
            const percentage = Math.round((correctAnswers / totalQuestions) * 100);
            const timeTaken = Math.floor((new Date() - quizStartTime) / 1000);
            
            console.log('Score calculation:', {
                correctAnswers: correctAnswers,
                totalQuestions: totalQuestions,
                percentage: percentage,
                timeTaken: timeTaken
            });
            
            return {
                correctAnswers: correctAnswers,
                incorrectAnswers: totalQuestions - correctAnswers,
                percentage: percentage,
                timeTaken: timeTaken,
                answers: answers
            };
        }
        
        // Show results
        function showResults(result) {
            console.log('Showing results:', result);
            
            // Stop timer
            clearInterval(timeInterval);
            
            // Hide form, show results
            $('#quizForm').hide();
            $('#quizResults').show();
            
            // Update result elements
            $('#correctCount').text(result.correctAnswers);
            $('#incorrectCount').text(result.incorrectAnswers);
            $('#scorePercentage').text(result.percentage + '%');
            $('#finalTime').text(result.timeTaken);
            
            // Set result icon and message
            let iconHtml = '';
            let message = '';
            let isPassed = result.percentage >= 75;
            
            if (result.percentage >= 80) {
                iconHtml = '<i class="bi bi-trophy text-warning" style="font-size: 3rem;"></i>';
                message = 'Excellent! You have a strong understanding of the material.';
            } else if (result.percentage >= 75) {
                iconHtml = '<i class="bi bi-award text-success" style="font-size: 3rem;"></i>';
                message = 'Great job! You passed the quiz and completed the course!';
            } else if (result.percentage >= 60) {
                iconHtml = '<i class="bi bi-award text-primary" style="font-size: 3rem;"></i>';
                message = 'Good work! Review the incorrect answers to improve your knowledge.';
            } else {
                iconHtml = '<i class="bi bi-bar-chart text-muted" style="font-size: 3rem;"></i>';
                message = 'Keep studying! Review the course material and try again.';
            }
            
            $('#resultIcon').html(iconHtml);
            $('#scoreMessage').text(message);
            
            // Show course completion message if passed
            if (isPassed) {
                $('#scoreMessage').after(`
                    <div class="mt-3 p-3" style="background: #D1FADF; border-radius: 8px;">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-award-fill text-success me-2"></i>
                            <span style="color: #12B76A; font-weight: 600;">🎉 Course Completed Successfully!</span>
                        </div>
                        <p class="text-center mt-2 mb-0" style="color: #12B76A; font-size: 0.9em;">
                            You have completed all requirements for this course.
                        </p>
                    </div>
                `);
            }
            
            // Submit to server
            submitQuizResult(result);
        }
        
        // Submit quiz result to server
        function submitQuizResult(result) {
            console.log('Submitting quiz result to server...');
            
            $.ajax({
                url: '{{ route("lesson.quiz", ["course" => $course->id, "lesson" => $lesson->id]) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                data: JSON.stringify({
                    answers: result.answers,
                    timeTaken: result.timeTaken
                }),
                success: function(response) {
                    console.log('Quiz submitted successfully:', response);
                    // Update lesson completion status
                    updateLessonCompletion();
                },
                error: function(xhr, status, error) {
                    console.error('Error submitting quiz:', error);
                    console.error('Response:', xhr.responseText);
                    // Still show results even if server submission fails
                    updateLessonCompletion();
                }
            });
        }
        
        // Update lesson completion status
        function updateLessonCompletion() {
            console.log('Updating lesson completion status...');
            
            // Hide the "Mark Complete" button since quiz completion counts as completion
            $('#markCompleteBtn').hide();
            
            // Get the score percentage
            const scorePercentage = $('#scorePercentage').text();
            const isPassed = parseInt(scorePercentage) >= 75;
            
            // Show completion message
            let completionMessage = '';
            if (isPassed) {
                completionMessage = `
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center gap-2 text-success mb-2">
                            <i class="bi bi-check-circle"></i>
                            <span class="fw-medium">Lesson completed!</span>
                        </div>
                        <p class="text-muted small">Quiz passed with ${scorePercentage} score</p>
                        <div class="mt-2 p-2" style="background: #D1FADF; border-radius: 6px;">
                            <small style="color: #12B76A; font-weight: 500;">
                                <i class="bi bi-award me-1"></i>Course completion requirement met!
                            </small>
                        </div>
                    </div>
                `;
            } else {
                completionMessage = `
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center gap-2 text-warning mb-2">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span class="fw-medium">Quiz completed</span>
                        </div>
                        <p class="text-muted small">Quiz score: ${scorePercentage} (minimum 75% required)</p>
                        <div class="mt-2 p-2" style="background: #FEF9C3; border-radius: 6px;">
                            <small style="color: #FEC84B; font-weight: 500;">
                                <i class="bi bi-info-circle me-1"></i>Retake quiz to meet course completion requirements
                            </small>
                        </div>
                    </div>
                `;
            }
            
            $('.lesson-actions').html(completionMessage);
        }
        
        // Event listeners
        $('input[type="radio"]').on('change', function() {
            console.log('Radio button changed');
            checkAllAnswered();
        });
        
        $('#submitQuizBtn').on('click', function(e) {
            console.log('Submit button clicked');
            e.preventDefault();
            
            if (checkAllAnswered()) {
                const result = calculateScore();
                showResults(result);
                quizSubmitted = true;
            } else {
                console.log('Not all questions answered');
            }
        });
        
        $('#showAnswersBtn').on('click', function() {
            console.log('Show answers button clicked');
            
            // Show correct answers
            questions.forEach(function(question) {
                const correctOption = $(`#option_${question.id}_${question.correct_answer}`);
                correctOption.closest('.form-check').addClass('border border-success bg-light');
                correctOption.closest('.form-check').append('<small class="text-success ms-2"><i class="bi bi-check-circle"></i> Correct</small>');
            });
            
            // Disable form
            $('input[type="radio"]').prop('disabled', true);
            $('#submitQuizBtn').prop('disabled', true);
            $('#showAnswersBtn').prop('disabled', true);
        });
        
        $('#retakeQuizBtn').on('click', function() {
            console.log('Retake quiz button clicked');
            
            // Reset form
            $('input[type="radio"]').prop('checked', false).prop('disabled', false);
            $('#quizForm').show();
            $('#quizResults').hide();
            $('#submitMessage').hide();
            $('#submitQuizBtn').prop('disabled', true);
            $('#showAnswersBtn').prop('disabled', false);
            
            // Reset timer
            quizStartTime = new Date();
            startTimer();
            quizSubmitted = false;
        });
        
        // Start timer when page loads
        startTimer();
        
        // Check initial state
        checkAllAnswered();
        
        console.log('Quiz functionality initialized successfully');
    } else {
        console.log('No quiz form found on this page');
    }
    
    // Mark lesson complete functionality
    const markCompleteBtn = document.getElementById('markCompleteBtn');
    
    if (markCompleteBtn) {
        console.log('Mark complete button found');
        
        markCompleteBtn.addEventListener('click', function() {
            console.log('Mark complete button clicked');
            
            // Show loading state
            const originalText = markCompleteBtn.innerHTML;
            markCompleteBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Marking Complete...';
            markCompleteBtn.disabled = true;
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Make AJAX request
            fetch('{{ route("lesson.complete", ["course" => $course->id, "lesson" => $lesson->id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    notes: '' // You can add a notes field if needed
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Mark complete response:', data);
                if (data.success) {
                    // Update button to show completed state
                    markCompleteBtn.innerHTML = '<i class="bi bi-check-circle"></i> Completed';
                    markCompleteBtn.style.background = '#8cb33a';
                    markCompleteBtn.style.borderColor = '#8cb33a';
                    markCompleteBtn.disabled = true;
                    
                    // Show success message
                    showNotification('Lesson marked as complete!', 'success');
                    
                    // Update progress in sidebar if it exists
                    try {
                        updateProgressInSidebar();
                    } catch (error) {
                        console.warn('Could not update progress in sidebar:', error);
                    }
                    
                    // Update the lesson card in sidebar to show completion
                    try {
                        updateLessonCardInSidebar();
                    } catch (error) {
                        console.warn('Could not update lesson card in sidebar:', error);
                    }
                } else {
                    throw new Error(data.message || 'Failed to mark lesson as complete');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to mark lesson as complete. Please try again.', 'error');
                
                // Reset button state
                markCompleteBtn.innerHTML = originalText;
                markCompleteBtn.disabled = false;
            });
        });
    } else {
        console.log('No mark complete button found');
    }
    
    // Notification function
    function showNotification(message, type) {
        console.log('Showing notification:', message, type);
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
    
    // Update progress in sidebar
    function updateProgressInSidebar() {
        console.log('Updating progress in sidebar');
        
        // Update both progress bars (top and sidebar)
        const progressBars = document.querySelectorAll('.progress-bar');
        const progressTexts = document.querySelectorAll('.text-muted');
        
        // Get current progress values
        const currentCompleted = {{ $completedLessons }};
        const totalLessons = {{ $totalLessons }};
        const newCompleted = currentCompleted + 1;
        const newPercentage = Math.round((newCompleted / totalLessons) * 100);
        
        // Update all progress bars
        progressBars.forEach(bar => {
            bar.style.width = newPercentage + '%';
        });
        
        // Update all progress texts
        progressTexts.forEach(text => {
            if (text.textContent.includes('lessons completed')) {
                text.textContent = `${newCompleted} of ${totalLessons} lessons completed`;
            }
            if (text.textContent.includes('%')) {
                text.textContent = `${newPercentage}%`;
            }
        });
        
        // Update the top course progress section
        const topProgressText = document.querySelector('.card-body .d-flex .text-sm.text-gray-600');
        if (topProgressText) {
            topProgressText.textContent = `${newCompleted} of ${totalLessons} lessons completed`;
        }
        
        const topProgressPercentage = document.querySelector('.card-body .text-sm.text-gray-600.mb-0');
        if (topProgressPercentage) {
            topProgressPercentage.textContent = `${newPercentage}% complete`;
        }
    }
    
    // Update lesson card in sidebar
    function updateLessonCardInSidebar() {
        console.log('Updating lesson card in sidebar');
        
        const currentLessonId = '{{ $lesson->id }}';
        const lessonItems = document.querySelectorAll('.lesson-item');
        
        lessonItems.forEach(item => {
            const link = item.querySelector('a');
            if (link && link.href && link.href.includes(currentLessonId)) {
                item.style.background = '#e8f5e8';
                item.style.borderColor = '#8cb33a';
            }
        });
    }
    
    console.log('All event listeners attached successfully');
});
</script>

@endsection 