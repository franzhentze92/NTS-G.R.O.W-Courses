<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LessonProgress;
use App\Models\Course;

class GetPerfectQuizScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:perfect-completions {--limit=25 : Number of results to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the first users who completed entire courses with 100% quiz scores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        
        $this->info("Fetching first {$limit} users with perfect course completions...\n");
        
        // Get all courses
        $courses = Course::with(['lessons'])->get();
        
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
                    $timeTaken = $this->extractTimeFromNotes($completion->notes);
                    
                    $perfectCompletions->push([
                        'user_name' => $completion->user->name,
                        'course_title' => $course->title,
                        'score' => $completion->quiz_score . '%',
                        'completed_lessons' => $completedLessons,
                        'total_lessons' => $totalLessons,
                        'time_taken' => $timeTaken ?? 'N/A',
                        'submitted_at' => $completion->completed_at->format('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
        // Sort by completion time and limit
        $perfectCompletions = $perfectCompletions
            ->sortBy('submitted_at')
            ->take($limit)
            ->values();

        if ($perfectCompletions->isEmpty()) {
            $this->warn('No perfect course completions found yet.');
            return;
        }

        // Create table headers
        $headers = ['#', 'User Name', 'Course', 'Quiz Score', 'Lessons', 'Time (s)', 'Completed At'];
        
        $rows = [];
        foreach ($perfectCompletions as $index => $completion) {
            $rows[] = [
                $index + 1,
                $completion['user_name'],
                $completion['course_title'],
                $completion['score'],
                $completion['completed_lessons'] . '/' . $completion['total_lessons'],
                $completion['time_taken'],
                $completion['submitted_at']
            ];
        }

        $this->table($headers, $rows);
        
        $this->info("\nTotal perfect course completions found: " . $perfectCompletions->count());
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