<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\QuizQuestion;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor', 'lessons'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('course-management', compact('courses'));
    }

    public function catalog()
    {
        $courses = Course::with(['instructor', 'lessons'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('courses', compact('courses'));
    }

    public function create()
    {
        $instructors = Instructor::all();
        return view('course-create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'level' => 'required|string',
            'type' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|url',
            'tags' => 'nullable|array',
            'status' => 'required|in:draft,published,archived',
            'instructor_id' => 'nullable|exists:instructors,id',
            'duration_hours' => 'nullable|integer|min:1',
            'featured' => 'boolean',
            'certification' => 'boolean',
            'lessons' => 'required|array|min:1',
            'lessons.*.title' => 'required|string',
            'lessons.*.type' => 'required|in:reading,video,quiz',
            'lessons.*.duration' => 'required|integer|min:1',
            'lessons.*.content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create course
            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'level' => $request->level,
                'type' => $request->type,
                'price' => $request->price ?? 0,
                'cover_image' => $request->cover_image,
                'tags' => $request->tags,
                'status' => $request->status,
                'instructor_id' => $request->instructor_id,
                'duration_hours' => $request->duration_hours ?? 2,
                'featured' => $request->featured ?? false,
                'certification' => $request->certification ?? false,
                'lessons_count' => count($request->lessons)
            ]);

            // Create lessons
            foreach ($request->lessons as $index => $lessonData) {
                $lesson = $course->lessons()->create([
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'duration_minutes' => $lessonData['duration'],
                    'content' => $lessonData['content'],
                    'order' => $index + 1
                ]);

                // Create quiz questions if lesson is quiz type
                if ($lessonData['type'] === 'quiz' && isset($lessonData['questions'])) {
                    foreach ($lessonData['questions'] as $qIndex => $questionData) {
                        $lesson->quizQuestions()->create([
                            'question' => $questionData['question'],
                            'options' => $questionData['options'],
                            'correct_answer' => $questionData['correct'],
                            'order' => $qIndex + 1
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Course created successfully!',
                'course_id' => $course->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'lessons.quizQuestions'])
            ->findOrFail($id);

        // Group lessons by chapters
        $chapters = [];
        $currentChapter = null;
        $currentChapterLessons = [];
        
        foreach ($course->lessons as $lesson) {
            $chapterNumber = ceil($lesson->order / 3);
            
            if ($currentChapter !== $chapterNumber) {
                if ($currentChapter !== null) {
                    $chapters[] = [
                        'number' => $currentChapter,
                        'title' => 'Chapter ' . $currentChapter,
                        'lessons' => $currentChapterLessons
                    ];
                }
                $currentChapter = $chapterNumber;
                $currentChapterLessons = [];
            }
            
            $currentChapterLessons[] = $lesson;
        }
        
        // Add the last chapter
        if ($currentChapter !== null) {
            $chapters[] = [
                'number' => $currentChapter,
                'title' => 'Chapter ' . $currentChapter,
                'lessons' => $currentChapterLessons
            ];
        }

        return view('course-detail', compact('course', 'chapters'));
    }

    public function edit($id)
    {
        $course = Course::with(['instructor', 'lessons.quizQuestions'])
            ->findOrFail($id);
        $instructors = Instructor::all();

        return view('course-edit', compact('course', 'instructors'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'level' => 'required|string',
            'type' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|url',
            'tags' => 'nullable|array',
            'status' => 'required|in:draft,published,archived',
            'instructor_id' => 'nullable|exists:instructors,id',
            'duration_hours' => 'nullable|integer|min:1',
            'featured' => 'boolean',
            'certification' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $course->update([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'level' => $request->level,
                'type' => $request->type,
                'price' => $request->price ?? 0,
                'cover_image' => $request->cover_image,
                'tags' => $request->tags,
                'status' => $request->status,
                'instructor_id' => $request->instructor_id,
                'duration_hours' => $request->duration_hours ?? 2,
                'featured' => $request->featured ?? false,
                'certification' => $request->certification ?? false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $status = $request->status;

        if (!in_array($status, ['draft', 'published', 'archived'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status'
            ], 400);
        }

        $course->update(['status' => $status]);

        return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully!'
        ]);
    }

    public function getCourses(Request $request)
    {
        $query = Course::with(['instructor', 'lessons']);

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filters
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->level && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        if ($request->type && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $courses = $query->orderBy('created_at', 'desc')->get();

        return response()->json($courses);
    }

    public function showLesson($courseId, $lessonId)
    {
        $course = Course::with(['instructor', 'lessons.quizQuestions'])
            ->findOrFail($courseId);
        
        $lesson = $course->lessons()->with('quizQuestions')->findOrFail($lessonId);
        
        // Get previous and next lessons
        $previousLesson = $course->lessons()
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();
            
        $nextLesson = $course->lessons()
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();

        // Group lessons by chapters
        $chapters = [];
        $currentChapter = null;
        $currentChapterLessons = [];
        
        foreach ($course->lessons as $courseLesson) {
            $chapterNumber = ceil($courseLesson->order / 3);
            
            if ($currentChapter !== $chapterNumber) {
                if ($currentChapter !== null) {
                    $chapters[] = [
                        'number' => $currentChapter,
                        'title' => 'Chapter ' . $currentChapter,
                        'lessons' => $currentChapterLessons
                    ];
                }
                $currentChapter = $chapterNumber;
                $currentChapterLessons = [];
            }
            
            $currentChapterLessons[] = $courseLesson;
        }
        
        // Add the last chapter
        if ($currentChapter !== null) {
            $chapters[] = [
                'number' => $currentChapter,
                'title' => 'Chapter ' . $currentChapter,
                'lessons' => $currentChapterLessons
            ];
        }

        return view('lesson', compact('course', 'lesson', 'previousLesson', 'nextLesson', 'chapters'));
    }
}
