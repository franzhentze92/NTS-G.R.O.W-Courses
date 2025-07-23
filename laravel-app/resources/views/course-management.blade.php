@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="max-width: 1400px;">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-0" style="font-size: 2.2em; font-weight: bold; color: #101828;">Course Management</h1>
                    <p class="text-muted mb-0" style="font-size: 1.1em;">Create, edit, and manage your educational courses</p>
                </div>
                <a href="/admin/course-create" class="btn d-flex align-items-center gap-2" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                    <i class="bi bi-plus-circle"></i> Add New Course
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-0" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="font-size: 0.9em; color: #667085; font-weight: 500;">Total Courses</p>
                                    <h3 class="mb-0" style="font-size: 2em; font-weight: bold; color: #101828;" id="totalCourses">{{ $courses->count() }}</h3>
                                </div>
                                <i class="bi bi-collection" style="font-size: 2em; color: #8cb33a;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-0" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="font-size: 0.9em; color: #667085; font-weight: 500;">Published</p>
                                    <h3 class="mb-0" style="font-size: 2em; font-weight: bold; color: #101828;" id="publishedCourses">{{ $courses->where('status', 'published')->count() }}</h3>
                                </div>
                                <i class="bi bi-check-circle" style="font-size: 2em; color: #12B76A;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-0" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="font-size: 0.9em; color: #667085; font-weight: 500;">Drafts</p>
                                    <h3 class="mb-0" style="font-size: 2em; font-weight: bold; color: #101828;" id="draftCourses">{{ $courses->where('status', 'draft')->count() }}</h3>
                                </div>
                                <i class="bi bi-pencil-square" style="font-size: 2em; color: #FEC84B;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-0" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="font-size: 0.9em; color: #667085; font-weight: 500;">Total Lessons</p>
                                    <h3 class="mb-0" style="font-size: 2em; font-weight: bold; color: #101828;" id="totalLessons">{{ $courses->sum('lessons_count') }}</h3>
                                </div>
                                <i class="bi bi-book" style="font-size: 2em; color: #8cb33a;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 18px;">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #344054;">Search Courses</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: transparent; border-right: none;">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by title, description, or instructor..." style="border-left: none;">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #344054;">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #344054;">Category</label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
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
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #344054;">Level</label>
                            <select class="form-select" id="levelFilter">
                                <option value="">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #344054;">Type</label>
                            <select class="form-select" id="typeFilter">
                                <option value="">All Types</option>
                                <option value="theory">Theory</option>
                                <option value="practice">Practice</option>
                                <option value="mixed">Mixed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course List -->
            <div id="courseList">
                @if($courses->count() > 0)
                    @foreach($courses as $course)
                        <div class="card shadow-sm border-0 mb-3" style="border-radius: 18px;">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <img src="{{ $course->cover_image ?: '/how-to-thumbnails-languages/grow-courses.jpeg' }}" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;" alt="Course image">
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <h5 class="mb-0" style="font-weight: 600; color: #101828;">{{ $course->title }}</h5>
                                            <span class="badge {{ $course->status_color }}">{{ $course->status }}</span>
                                            <span class="badge {{ $course->category_color }}">{{ str_replace('-', ' ', $course->category) }}</span>
                                        </div>
                                        <p class="text-muted mb-2" style="font-size: 0.9em;">{{ $course->description }}</p>
                                        <div class="d-flex align-items-center gap-3 mb-2" style="font-size: 0.85em; color: #667085;">
                                            @if($course->instructor)
                                                <span><i class="bi bi-person me-1"></i>{{ $course->instructor->name }}</span>
                                            @endif
                                            <span><i class="bi bi-book me-1"></i>{{ $course->lessons_count }} lessons</span>
                                            <span><i class="bi bi-people me-1"></i>{{ $course->students_count }} students</span>
                                            @if($course->rating > 0)
                                                <span><i class="bi bi-star-fill me-1" style="color: #FEC84B;"></i>{{ $course->rating }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.8em;">{{ $course->level }}</span>
                                            <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.8em;">{{ $course->type }}</span>
                                            <span class="fw-bold" style="color: #101828;">{{ $course->formatted_price }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex flex-column gap-2">
                                            <a href="/courses/{{ $course->id }}" class="btn d-flex align-items-center justify-content-center gap-2" style="background: transparent; color: #8cb33a; border: 1px solid #8cb33a; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <a href="/admin/course-edit/{{ $course->id }}" class="btn d-flex align-items-center justify-content-center gap-2" style="background: transparent; color: #667085; border: 1px solid #d0d5dd; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <button class="btn d-flex align-items-center justify-content-center gap-2 course-action-btn" data-course-id="{{ $course->id }}" data-action="{{ $course->status === 'published' ? 'unpublish' : 'publish' }}" style="background: transparent; color: {{ $course->status === 'published' ? '#FEC84B' : '#12B76A' }}; border: 1px solid {{ $course->status === 'published' ? '#FEC84B' : '#12B76A' }}; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                                <i class="bi bi-{{ $course->status === 'published' ? 'eye-slash' : 'check-circle' }}"></i> {{ $course->status === 'published' ? 'Unpublish' : 'Publish' }}
                                            </button>
                                            <button class="btn d-flex align-items-center justify-content-center gap-2 course-action-btn" data-course-id="{{ $course->id }}" data-action="delete" style="background: transparent; color: #F04438; border: 1px solid #F04438; border-radius: 8px; font-weight: 600; font-size: 0.9em;">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card shadow-sm border-0" style="border-radius: 18px;">
                        <div class="card-body p-5 text-center">
                            <i class="bi bi-collection" style="font-size: 3em; color: #d0d5dd; margin-bottom: 1rem;"></i>
                            <h4 style="color: #101828; font-weight: 600;">No courses found</h4>
                            <p style="color: #667085;">Get started by creating your first course</p>
                            <a href="/admin/course-create" class="btn d-flex align-items-center gap-2 mx-auto" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em; width: fit-content;">
                                <i class="bi bi-plus-circle"></i> Create First Course
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Sample course data for demonstration
const sampleCourses = [
    {
        id: 1,
        title: 'Soil Testing Mastery: Foundations of Nutrition Farming®',
        description: 'Master the art of soil testing and unlock the hidden language of your soil. Learn from Dr. Graeme Sait, pioneer of Nutrition Farming®.',
        status: 'published',
        category: 'soil-health',
        level: 'intermediate',
        type: 'mixed',
        instructor: 'Dr. Graeme Sait',
        lessons_count: 13,
        students_count: 45,
        rating: 4.8,
        price: 0,
        cover_image: '/how-to-thumbnails-languages/grow-courses.jpeg'
    },
    {
        id: 2,
        title: 'Advanced Plant Nutrition Techniques',
        description: 'Deep dive into plant nutrition, micronutrients, and advanced growing techniques for maximum crop yield and quality.',
        status: 'published',
        category: 'plant-health',
        level: 'advanced',
        type: 'theory',
        instructor: 'Prof. John Doe',
        lessons_count: 8,
        students_count: 32,
        rating: 4.6,
        price: 99,
        cover_image: '/how-to-thumbnails-languages/grow-courses.jpeg'
    },
    {
        id: 3,
        title: 'Sustainable Agriculture Practices',
        description: 'Learn eco-friendly farming methods that protect the environment while maintaining high productivity and profitability.',
        status: 'draft',
        category: 'sustainable-practices',
        level: 'beginner',
        type: 'practice',
        instructor: 'Dr. Jane Smith',
        lessons_count: 6,
        students_count: 0,
        rating: 0,
        price: 49,
        cover_image: '/how-to-thumbnails-languages/grow-courses.jpeg'
    },
    {
        id: 4,
        title: 'Crop Protection Strategies',
        description: 'Comprehensive guide to protecting your crops from pests, diseases, and environmental stresses using integrated pest management.',
        status: 'published',
        category: 'crop-protection',
        level: 'intermediate',
        type: 'mixed',
        instructor: 'Dr. Graeme Sait',
        lessons_count: 10,
        students_count: 28,
        rating: 4.7,
        price: 79,
        cover_image: '/how-to-thumbnails-languages/grow-courses.jpeg'
    },
    {
        id: 5,
        title: 'Business & Marketing for Farmers',
        description: 'Essential business skills for modern farmers: marketing, financial planning, and building sustainable farm enterprises.',
        status: 'draft',
        category: 'business-marketing',
        level: 'beginner',
        type: 'theory',
        instructor: 'Prof. John Doe',
        lessons_count: 5,
        students_count: 0,
        rating: 0,
        price: 29,
        cover_image: '/how-to-thumbnails-languages/grow-courses.jpeg'
    }
];

$(document).ready(function() {
    // Course action buttons
    $(document).on('click', '.course-action-btn', function() {
        const courseId = $(this).data('course-id');
        const action = $(this).data('action');
        const button = $(this);

        if (action === 'delete') {
            if (confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
                $.ajax({
                    url: `/admin/courses/${courseId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Course deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting course. Please try again.');
                    }
                });
            }
        } else if (action === 'publish' || action === 'unpublish') {
            const newStatus = action === 'publish' ? 'published' : 'draft';
            
            $.ajax({
                url: `/admin/courses/${courseId}/status`,
                method: 'PATCH',
                data: {
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(`Course ${newStatus} successfully!`);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error updating course status. Please try again.');
                }
            });
        }
    });

    // Search and filter functionality
    function filterCourses() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const statusFilter = $('#statusFilter').val();
        const categoryFilter = $('#categoryFilter').val();
        const levelFilter = $('#levelFilter').val();
        const typeFilter = $('#typeFilter').val();

        $('.card').each(function() {
            const card = $(this);
            const title = card.find('h5').text().toLowerCase();
            const description = card.find('p').text().toLowerCase();
            const status = card.find('.badge').first().text().toLowerCase();
            const category = card.find('.badge').eq(1).text().toLowerCase();
            const level = card.find('.badge').eq(2).text().toLowerCase();
            const type = card.find('.badge').eq(3).text().toLowerCase();

            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesCategory = !categoryFilter || category.includes(categoryFilter.replace('-', ' '));
            const matchesLevel = !levelFilter || level === levelFilter;
            const matchesType = !typeFilter || type === typeFilter;

            if (matchesSearch && matchesStatus && matchesCategory && matchesLevel && matchesType) {
                card.show();
            } else {
                card.hide();
            }
        });

        // Update stats
        updateStats();
    }

    function updateStats() {
        const visibleCards = $('.card').filter(function() {
            return $(this).is(':visible') && $(this).find('h5').length > 0;
        });

        $('#totalCourses').text(visibleCards.length);
        
        const publishedCount = visibleCards.filter(function() {
            return $(this).find('.badge').first().text() === 'published';
        }).length;
        
        const draftCount = visibleCards.filter(function() {
            return $(this).find('.badge').first().text() === 'draft';
        }).length;

        $('#publishedCourses').text(publishedCount);
        $('#draftCourses').text(draftCount);
    }

    // Event listeners for search and filters
    $('#searchInput, #statusFilter, #categoryFilter, #levelFilter, #typeFilter').on('change keyup', filterCourses);
});
</script>
@endsection 