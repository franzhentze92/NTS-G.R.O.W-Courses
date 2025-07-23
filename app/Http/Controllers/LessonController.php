<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($courseId, $lessonId)
    {
        $course = Course::with(['lessons' => function($query) {
            $query->orderBy('order');
        }, 'instructor'])->findOrFail($courseId);
        
        $lesson = $course->lessons()->findOrFail($lessonId);
        
        // Get current user's progress for this lesson
        $userProgress = null;
        $userId = 1; // Default user ID since authentication isn't set up
        $userProgress = LessonProgress::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->where('course_id', $courseId)
            ->first();
        
        // Get completion status for all lessons in this course
        $lessonProgress = LessonProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
        
        // Calculate course progress
        $completedLessons = count($lessonProgress);
        $totalLessons = $course->lessons->count();
        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        // Get previous and next lessons
        $currentIndex = $course->lessons->search(function($item) use ($lessonId) {
            return $item->id == $lessonId;
        });
        
        $previousLesson = $currentIndex > 0 ? $course->lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $course->lessons->count() - 1 ? $course->lessons[$currentIndex + 1] : null;
        
        // Group lessons by chapters based on their actual content
        $chapters = [];
        
        // Get all lessons ordered by their order field
        $orderedLessons = $course->lessons->sortBy('order');
        
        // Chapter 1: Lessons with chapter = 1
        $chapters[] = [
            'title' => 'Chapter 1: Foundation',
            'lessons' => $orderedLessons->where('chapter', 1)->sortBy('order')
        ];
        
        // Chapter 2: Lessons with chapter = 2
        $chapters[] = [
            'title' => 'Chapter 2: Cracking the Code',
            'lessons' => $orderedLessons->where('chapter', 2)->sortBy('order')
        ];
        
        // Chapter 3: Lessons with chapter = 3
        $chapters[] = [
            'title' => 'Chapter 3: From Data to Decisions',
            'lessons' => $orderedLessons->where('chapter', 3)->sortBy('order')
        ];
        
        // Chapter 4: Lessons with chapter = 4
        $chapters[] = [
            'title' => 'Chapter 4: Mastering Mineral Ratios',
            'lessons' => $orderedLessons->where('chapter', 4)->sortBy('order')
        ];
        
        return view('lesson', compact('course', 'lesson', 'previousLesson', 'nextLesson', 'chapters', 'userProgress', 'lessonProgress', 'completedLessons', 'totalLessons', 'progressPercentage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }

    /**
     * Mark lesson as complete
     */
    public function markComplete(Request $request, $courseId, $lessonId)
    {
        // For now, use a default user ID since authentication isn't set up
        $userId = 1; // Default user ID

        $lesson = Lesson::findOrFail($lessonId);
        $course = Course::findOrFail($courseId);

        // Create or update lesson progress
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'course_id' => $courseId,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
                'notes' => $request->input('notes')
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as complete',
            'progress' => $progress
        ]);
    }

    /**
     * Submit quiz and calculate score
     */
    public function submitQuiz(Request $request, $courseId, $lessonId)
    {
        // For now, use a default user ID since authentication isn't set up
        $userId = 1; // Default user ID

        $lesson = Lesson::with('quizQuestions')->findOrFail($lessonId);
        $course = Course::findOrFail($courseId);

        // Get quiz answers from request
        $answers = $request->input('answers', []);
        $timeTaken = $request->input('timeTaken', 0);

        // Calculate score
        $totalQuestions = $lesson->quizQuestions->count();
        $correctAnswers = 0;
        $scoreDetails = [];

        foreach ($lesson->quizQuestions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer !== null && $userAnswer == $question->correct_answer;
            
            if ($isCorrect) {
                $correctAnswers++;
            }
            
            $scoreDetails[] = [
                'question_id' => $question->id,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $isPassed = $score >= 75;

        // Create or update lesson progress
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'course_id' => $courseId,
            ],
            [
                'is_completed' => $isPassed, // Only mark as completed if score >= 75%
                'completed_at' => $isPassed ? now() : null,
                'quiz_score' => $score,
                'notes' => $isPassed 
                    ? "Quiz passed with {$score}% score. Time taken: {$timeTaken}s. Correct answers: {$correctAnswers}/{$totalQuestions}"
                    : "Quiz failed with {$score}% score (minimum 75% required). Time taken: {$timeTaken}s. Correct answers: {$correctAnswers}/{$totalQuestions}"
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully',
            'result' => [
                'score' => $score,
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
                'incorrectAnswers' => $totalQuestions - $correctAnswers,
                'timeTaken' => $timeTaken,
                'scoreDetails' => $scoreDetails
            ],
            'progress' => $progress
        ]);
    }

    /**
     * Get the first 25 users who achieved 100% on the quiz
     */
    public function getPerfectQuizScores()
    {
        // Get users who completed the final quiz with 100% score
        $perfectScores = LessonProgress::with(['user', 'lesson', 'course'])
            ->where('quiz_score', 100)
            ->where('is_completed', true)
            ->whereHas('lesson', function($query) {
                $query->where('type', 'quiz');
            })
            ->orderBy('completed_at', 'asc')
            ->limit(25)
            ->get()
            ->map(function ($progress) {
                return [
                    'user_name' => $progress->user->name,
                    'score' => $progress->quiz_score,
                    'submitted_at' => $progress->completed_at->format('Y-m-d H:i:s'),
                    'course_title' => $progress->course->title,
                    'time_taken' => $this->extractTimeFromNotes($progress->notes)
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $perfectScores,
            'count' => $perfectScores->count()
        ]);
    }

    /**
     * Get the first 25 users who completed the entire course with 100% quiz score
     */
    public function getPerfectCourseCompletions()
    {
        // Get all courses
        $courses = \App\Models\Course::with(['lessons', 'instructor'])->get();
        
        $perfectCompletions = collect();
        
        foreach ($courses as $course) {
            // Get the final quiz lesson
            $finalQuiz = $course->lessons()->where('type', 'quiz')->orderBy('order', 'desc')->first();
            
            if (!$finalQuiz) continue;
            
            // Get users who completed the final quiz with 100% score
            $quizCompletions = LessonProgress::with(['user'])
                ->where('lesson_id', $finalQuiz->id)
                ->where('course_id', $course->id)
                ->where('quiz_score', 100)
                ->where('is_completed', true)
                ->orderBy('completed_at', 'asc')
                ->get();
            
            foreach ($quizCompletions as $completion) {
                // Check if user completed all lessons in the course
                $totalLessons = $course->lessons()->count();
                $completedLessons = LessonProgress::where('user_id', $completion->user_id)
                    ->where('course_id', $course->id)
                    ->where('is_completed', true)
                    ->count();
                
                // Only include if all lessons are completed
                if ($completedLessons >= $totalLessons) {
                    $perfectCompletions->push([
                        'user_name' => $completion->user->name,
                        'score' => $completion->quiz_score,
                        'submitted_at' => $completion->completed_at->format('Y-m-d H:i:s'),
                        'course_title' => $course->title,
                        'time_taken' => $this->extractTimeFromNotes($completion->notes),
                        'total_lessons' => $totalLessons,
                        'completed_lessons' => $completedLessons
                    ]);
                }
            }
        }
        
        // Sort by completion time and limit to 25
        $perfectCompletions = $perfectCompletions
            ->sortBy('submitted_at')
            ->take(25)
            ->values();

        return response()->json([
            'success' => true,
            'data' => $perfectCompletions,
            'count' => $perfectCompletions->count()
        ]);
    }

    /**
     * Extract time taken from notes field
     */
    private function extractTimeFromNotes($notes)
    {
        if (preg_match('/Time taken: (\d+)s/', $notes, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }
}
