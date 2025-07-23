@extends('layouts.app')

@section('content')
<style>
.progress {
    background-color: #f3f4f6 !important;
    border: 1px solid #e5e7eb;
}

.progress-bar {
    background-color: #8cb33a !important;
    border-radius: 4px;
    transition: width 0.6s ease;
}

.progress-bar:not([style*="width: 0%"]) {
    min-width: 2em;
}
</style>

<div class="container-fluid py-5" style="max-width: 1400px;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="/courses" class="btn d-flex align-items-center gap-2 mb-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                        <i class="bi bi-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>

            <!-- Hero/Header Section -->
            <div class="mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">
                    <div class="position-relative" style="height: 200px;">
                        <img src="{{ $course->cover_image ?: '/how-to-thumbnails-languages/grow-courses.jpeg' }}" class="w-100 h-100" style="object-fit: cover;" alt="Course cover">
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ str_replace('-', ' ', $course->category) }}</span>
                            <span class="badge" style="background: #D1FADF; color: #12B76A; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $course->level }}</span>
                            <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $course->type }}</span>
                        </div>
                        <h1 class="mb-3" style="font-size: 2.2em; font-weight: bold; color: #101828;">{{ $course->title }}</h1>
                        <p class="text-muted mb-3" style="font-size: 1.1em;">{{ $course->description }}</p>
                        
                        <div class="d-flex align-items-center gap-4 mb-3" style="color: #667085; font-size: 0.95em;">
                            <span><i class="bi bi-clock me-1"></i>{{ $course->duration_hours }} hours</span>
                            <span><i class="bi bi-journal-text me-1"></i>{{ $course->lessons_count }} lessons</span>
                            <span><i class="bi bi-calendar me-1"></i>Updated {{ $course->updated_at->format('Y-m-d') }}</span>
                        </div>

                        <!-- Progress Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-weight: 600; color: #101828;">Course Progress</span>
                                <span style="color: #667085;">{{ $progressPercentage }}%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 4px; background-color: #f3f4f6;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%; background-color: #8cb33a; border-radius: 4px;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">{{ $completedLessons }} of {{ $totalLessons }} lessons completed</small>
                        </div>

                        <!-- Course Completion Status -->
                        @if($progressPercentage > 0)
                            <div class="mb-4 p-3" style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #8cb33a;">
                                <h6 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-trophy me-2"></i>Course Completion Requirements
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            @if($isAllLessonsCompleted)
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <span style="color: #12B76A; font-weight: 500;">All lessons completed</span>
                                            @else
                                                <i class="bi bi-circle text-muted me-2"></i>
                                                <span style="color: #667085;">Complete all {{ $totalLessons }} lessons</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            @if($isQuizPassed)
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <span style="color: #12B76A; font-weight: 500;">Final quiz passed (≥75%)</span>
                                            @else
                                                <i class="bi bi-circle text-muted me-2"></i>
                                                <span style="color: #667085;">Pass final quiz with 75% or higher</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($isCourseCompleted)
                                    <div class="mt-3 p-3" style="background: #D1FADF; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-award-fill text-success me-2"></i>
                                            <span style="color: #12B76A; font-weight: 600;">🎉 Congratulations! Course completed successfully!</span>
                                        </div>
                                    </div>
                                @elseif($isAllLessonsCompleted && !$isQuizPassed)
                                    <div class="mt-3 p-3" style="background: #FEF9C3; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span style="color: #FEC84B; font-weight: 600;">⚠️ All lessons completed! Take the final quiz to complete the course.</span>
                                        </div>
                                        @if($finalQuiz)
                                            <a href="/courses/{{ $course->id }}/lessons/{{ $finalQuiz->id }}" class="btn btn-warning btn-sm mt-2">
                                                <i class="bi bi-question-circle me-1"></i>Take Final Quiz
                                            </a>
                                        @endif
                                    </div>
                                @elseif(!$isAllLessonsCompleted)
                                    <div class="mt-3 p-3" style="background: #FEF2F2; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle text-info me-2"></i>
                                            <span style="color: #667085; font-weight: 600;">📚 Continue completing lessons to unlock the final quiz.</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs" id="courseTabs" role="tablist" style="border-bottom: 1px solid #e5e7eb;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" style="border: none; color: #8cb33a; font-weight: 600; padding: 1rem 1.5rem;">
                                Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum" type="button" role="tab" style="border: none; color: #344054; font-weight: 600; padding: 1rem 1.5rem;">
                                Curriculum
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor" type="button" role="tab" style="border: none; color: #344054; font-weight: 600; padding: 1rem 1.5rem;">
                                Instructor
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4" id="courseTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="mb-4">
                                <h4 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-info-circle me-2"></i>About This Course
                                </h4>
                                <p style="color: #667085; line-height: 1.6;">{{ $course->description }}</p>
                            </div>

                            <div class="mb-4">
                                <h4 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-target me-2"></i>What You'll Learn
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to accurately read and interpret soil test results</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to work confidently with essential metrics such as CEC, TEC, pH, conductivity, and base saturation</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to understand nutrient interactions using visual frameworks like Mulder's Chart</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to diagnose imbalances and nutrient antagonisms that compromise plant health and yield potential</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to design targeted correction strategies based on mineral ratios and relationships</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">🌟</span>
                                        <span style="color: #667085; line-height: 1.4;">How to calculate input rates precisely and make smarter, more cost-effective agronomic decisions</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-4">
                                <h4 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-list-check me-2"></i>Prerequisites
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">✅</span>
                                        <span style="color: #667085; line-height: 1.4;">A basic understanding of soil science principles</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">✅</span>
                                        <span style="color: #667085; line-height: 1.4;">Familiarity with general agronomic practices or crop production</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">✅</span>
                                        <span style="color: #667085; line-height: 1.4;">Access to recent soil test reports (recommended, but not required)</span>
                                    </li>
                                    <li class="d-flex align-items-start mb-2">
                                        <span class="me-2" style="font-size: 1.2em; line-height: 1.4;">✅</span>
                                        <span style="color: #667085; line-height: 1.4;">An interest in improving soil health, nutrient management, and farm profitability</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Curriculum Tab -->
                        <div class="tab-pane fade" id="curriculum" role="tabpanel">
                            <h4 style="color: #101828; font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-list-ul me-2"></i>Course Curriculum
                            </h4>
                            
                            @if($course->lessons->count() > 0)
                                <div class="accordion" id="lessonsAccordion">
                                    @php $lessonCounter = 1; @endphp
                                    @foreach($chapters as $chapterIndex => $chapter)
                                        <div class="chapter-section mb-4">
                                            <h5 style="color: #8cb33a; font-weight: 600; margin-bottom: 1rem; font-size: 1.1em; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #eaf5d3; padding-bottom: 0.5rem;">
                                                {{ $chapter['title'] }}
                                            </h5>
                                            @foreach($chapter['lessons'] as $lesson)
                                                <div class="accordion-item border-0 mb-2" style="border-radius: 12px !important; background: {{ in_array($lesson->id, $lessonProgress) ? '#e8f5e8' : '#f8fafc' }};">
                                                    <h2 class="accordion-header" id="heading{{ $lesson->id }}">
                                                        <button class="accordion-button collapsed d-flex align-items-center justify-content-between p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $lesson->id }}" style="background: transparent; border: none; box-shadow: none;">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <span class="badge" style="background: {{ in_array($lesson->id, $lessonProgress) ? '#8cb33a' : '#8cb33a' }}; color: #fff; font-weight: 600; border-radius: 999px; font-size: 0.8em;">{{ $lessonCounter }}</span>
                                                                <span style="font-weight: 600; color: #101828;">{{ $lesson->title }}</span>
                                                                <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.75em;">{{ $lesson->type }}</span>
                                                                <span style="color: #667085; font-size: 0.9em;">{{ $lesson->duration_minutes }} min</span>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if(in_array($lesson->id, $lessonProgress))
                                                                    <span class="badge" style="background: #8cb33a; color: #fff; font-weight: 500; border-radius: 999px; font-size: 0.75em;">
                                                                        <i class="bi bi-check-circle me-1"></i>Completed
                                                                    </span>
                                                                @endif
                                                                @if($lesson->type === 'quiz')
                                                                    <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.75em;">
                                                                        {{ $lesson->quizQuestions->count() }} questions
                                                                    </span>
                                                                @endif
                                                                <i class="bi bi-chevron-down" style="color: #667085;"></i>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $lesson->id }}" class="accordion-collapse collapse" data-bs-parent="#lessonsAccordion">
                                                        <div class="accordion-body p-3" style="background: #fff; border-top: 1px solid #e5e7eb;">
                                                            <p style="color: #667085; margin-bottom: 1rem;">{{ Str::limit($lesson->content, 200) }}</p>
                                                            <a href="/courses/{{ $course->id }}/lessons/{{ $lesson->id }}" class="btn d-flex align-items-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 0.9em; width: fit-content;">
                                                                <i class="bi bi-play-circle"></i> Start Lesson
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $lessonCounter++; @endphp
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-list-ul" style="font-size: 3em; color: #d0d5dd;"></i>
                                    <p class="mt-2">No lessons available yet</p>
                                </div>
                            @endif
                        </div>

                        <!-- Instructor Tab -->
                        <div class="tab-pane fade" id="instructor" role="tabpanel">
                            @if($course->instructor)
                                <div class="d-flex align-items-start gap-4">
                                    <img src="{{ $course->instructor->avatar ?: 'https://via.placeholder.com/80' }}" class="rounded-circle" width="80" height="80" alt="Instructor">
                                    <div class="flex-grow-1">
                                        <h4 style="color: #101828; font-weight: 600; margin-bottom: 0.5rem;">{{ $course->instructor->name }}</h4>
                                        <p style="color: #667085; margin-bottom: 1rem;">{{ $course->instructor->title }}</p>
                                        @if($course->instructor->bio)
                                            <p style="color: #667085; line-height: 1.6;">{{ $course->instructor->bio }}</p>
                                        @endif
                                        <div class="d-flex align-items-center gap-3 mt-3">
                                            @if($course->instructor->email)
                                                <span style="color: #667085; font-size: 0.9em;">
                                                    <i class="bi bi-envelope me-1"></i>{{ $course->instructor->email }}
                                                </span>
                                            @endif
                                            @if($course->instructor->website)
                                                <a href="{{ $course->instructor->website }}" target="_blank" style="color: #8cb33a; text-decoration: none; font-size: 0.9em;">
                                                    <i class="bi bi-globe me-1"></i>Website
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-person" style="font-size: 3em; color: #d0d5dd;"></i>
                                    <p class="mt-2">No instructor assigned</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 18px; position: sticky; top: 20px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ $course->cover_image ?: '/how-to-thumbnails-languages/grow-courses.jpeg' }}" class="img-fluid rounded mb-3" style="width: 100%; height: 150px; object-fit: cover;" alt="Course image">
                        <h5 style="color: #101828; font-weight: 600; margin-bottom: 0.5rem;">{{ $course->formatted_price }}</h5>
                        <p style="color: #667085; font-size: 0.9em; margin-bottom: 0;">No payment required</p>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        @if($course->lessons->count() > 0)
                            <a href="/courses/{{ $course->id }}/lessons/{{ $course->lessons->first()->id }}" class="btn d-flex align-items-center justify-content-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                <i class="bi bi-play-circle"></i> Start Learning
                            </a>
                        @else
                            <button class="btn d-flex align-items-center justify-content-center gap-2" disabled style="background: #e5e7eb; color: #9ca3af; border-radius: 8px; font-weight: 600; border: 1.5px solid #e5e7eb; font-size: 1em;">
                                <i class="bi bi-clock"></i> Coming Soon
                            </button>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h6 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">Course includes:</h6>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="bi bi-journal-text me-2" style="color: #8cb33a;"></i>
                                <span style="color: #667085; font-size: 0.9em;">{{ $course->lessons_count }} lessons</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-2" style="color: #8cb33a;"></i>
                                <span style="color: #667085; font-size: 0.9em;">{{ $course->duration_hours }} hours of content</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="bi bi-infinity me-2" style="color: #8cb33a;"></i>
                                <span style="color: #667085; font-size: 0.9em;">Full lifetime access</span>
                            </li>
                        </ul>
                    </div>

                    @if($course->tags)
                        <div class="mb-4">
                            <h6 style="color: #101828; font-weight: 600; margin-bottom: 1rem;">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($course->tags as $tag)
                                    <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.8em;">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Tab functionality is handled by Bootstrap
    
    // Progress is already calculated server-side and displayed correctly
    // No need to override it with JavaScript
});
</script>
@endsection
