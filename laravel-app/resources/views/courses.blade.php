@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 1100px; background: transparent;">
    <div class="mb-8 text-center" style="background: transparent;">
        <h2 class="fw-bold mb-2" style="font-size: 2rem; background: transparent;">G.R.O.W Learning Center</h2>
        <p class="lead text-muted mx-auto" style="max-width: 700px; background: transparent;">
            Master sustainable agriculture through our comprehensive courses designed by industry experts. 
            From soil health to planetary wellness, advance your knowledge and skills.
        </p>
        <div class="my-3"></div>
    </div>
    <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 mx-auto mb-4" style="max-width: 1000px;">
        <!-- Search and Filter Section -->
        <div class="row g-2 align-items-center mb-3 flex-wrap">
                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div class="position-relative">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search courses, topics, or instructors...">
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <select id="categoryFilter" class="form-select">
                        <option value="all">All Categories</option>
                        <option value="soil-health">Soil Health</option>
                        <option value="plant-health">Plant Health</option>
                        <option value="human-health">Human Health</option>
                        <option value="animal-health">Animal Health</option>
                        <option value="planetary-health">Planetary Health</option>
                        <option value="crop-protection">Crop Protection</option>
                        <option value="sustainable-practices">Sustainable Practices</option>
                        <option value="technology">Technology</option>
                        <option value="business">Business & Marketing</option>
                        <option value="innovation">Innovation</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2">
                    <select id="levelFilter" class="form-select">
                        <option value="all">All Levels</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2 mt-2 mt-lg-0">
                    <select id="priceFilter" class="form-select">
                        <option value="all">All Prices</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                        <option value="under-50">Under $50</option>
                        <option value="50-100">$50 - $100</option>
                        <option value="over-100">Over $100</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2 mt-2 mt-lg-0">
                    <select id="typeFilter" class="form-select">
                        <option value="all">All Types</option>
                        <option value="Theory">Theory</option>
                        <option value="Practice">Practice</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                </div>
            </div>
            <!-- Results count -->
            <div class="text-muted small mb-3" id="resultsCount">
                Showing <span id="shownCount">0</span> of <span id="totalCount">0</span> courses
            </div>
        </div>

        <!-- Course Grid -->
        <div class="row g-4" id="coursesList">
            <!-- Courses will be rendered here by jQuery -->
        </div>
    </div>
</div>

<!-- Mock Data and jQuery Logic -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock data for courses
const mockCourses = [
    {
        id: 1,
        title: 'Introduction to Soil Health',
        description: 'Learn the basics of soil health and its importance in agriculture.',
        category: 'soil-health',
        level: 'Beginner',
        type: 'Theory',
        lessons: 8,
        duration: '2h 30m',
        updated_at: '2024-06-01',
        instructor: 'Dr. Jane Smith',
        instructor_avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
        price: 0,
        image: '/how-to-thumbnails-languages/grow-courses.jpeg',
        tags: ['soil', 'sustainability']
    },
    {
        id: 2,
        title: 'Advanced Plant Nutrition',
        description: 'Deep dive into plant nutrition and advanced growing techniques.',
        category: 'plant-health',
        level: 'Advanced',
        type: 'Practice',
        lessons: 12,
        duration: '4h 10m',
        updated_at: '2024-05-15',
        instructor: 'Prof. John Doe',
        instructor_avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
        price: 49,
        image: '/how-to-thumbnails-languages/grow-courses-marco.webp',
        tags: ['nutrition', 'advanced']
    },
    // Add more mock courses as needed
];

const categoryColors = {
    'soil-health': 'bg-success',
    'plant-health': 'bg-success',
    'human-health': 'bg-danger',
    'animal-health': 'bg-warning',
    'planetary-health': 'bg-info',
    'crop-protection': 'bg-primary',
    'sustainable-practices': 'bg-teal',
    'technology': 'bg-indigo',
    'business': 'bg-pink',
    'innovation': 'bg-yellow',
    'all': 'bg-secondary'
};

function getCategoryColor(category) {
    return categoryColors[category] || 'bg-secondary';
}

function getLevelBadgeColor(level) {
    if (level === 'Beginner') return 'bg-success text-white';
    if (level === 'Intermediate') return 'bg-info text-white';
    if (level === 'Advanced') return 'bg-danger text-white';
    return 'bg-secondary text-white';
}

function getTypeBadgeColor(type) {
    if (type === 'Theory') return 'bg-warning text-dark';
    if (type === 'Practice') return 'bg-primary text-white';
    if (type === 'Mixed') return 'bg-pink text-white';
    return 'bg-secondary text-white';
}

function renderCourses(courses) {
    const $list = $('#coursesList');
    $list.empty();
    if (courses.length === 0) {
        $list.append('<div class="col-12"><div class="alert alert-info">No courses found.</div></div>');
        return;
    }
    courses.forEach(course => {
        $list.append(`
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 course-card" style="background: #fff; border-radius: 18px; transition: transform 0.2s; cursor: pointer;">
                    <div class="position-relative" style="height: 120px; border-top-left-radius: 18px; border-top-right-radius: 18px; overflow: hidden;">
                        <img src="${course.image || '/how-to-thumbnails-languages/grow-courses.jpeg'}" class="card-img-top h-100 w-100 object-fit-cover" alt="Course image" style="object-fit: cover;">
                    </div>
                    <div class="card-body pb-2 pt-2">
                        <div class="d-flex align-items-center mb-1 gap-2">
                            <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.85em;">${course.category.replace('-', ' ')}</span>
                            <span class="badge" style="background: #D1FADF; color: #12B76A; font-weight: 500; border-radius: 999px; font-size: 0.85em;">${course.level}</span>
                            <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.85em;">${course.type}</span>
                        </div>
                        <h5 class="card-title mb-1 mt-2" style="font-size: 1.08em; line-height: 1.2; min-height: 2.2em; font-weight: bold; color: #101828;">${course.title}</h5>
                        <div class="d-flex align-items-center gap-3 mb-2" style="color: #667085; font-size: 0.97em;">
                            <i class="bi bi-clock"></i> <span>${course.duration}</span>
                            <i class="bi bi-journal-text"></i> <span>${course.lessons} lessons</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <img src="${course.instructor_avatar || 'https://via.placeholder.com/28'}" class="rounded-circle me-2 border" width="28" height="28" alt="Instructor">
                            <span style="font-weight: 600; color: #344054;">Instructor:</span>
                            <span class="ms-1" style="color: #344054;">${course.instructor}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="fw-bold" style="font-size: 1em; color: #101828;">${course.price === 0 ? 'Free' : '$' + course.price}</span>
                            <a href="/courses/${course.id}" class="btn d-flex align-items-center gap-2 px-3 py-1" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `);
    });
    // Update result count
    $('#shownCount').text(courses.length);
    $('#totalCount').text(mockCourses.length);
    // Card hover effect
    $('.course-card').hover(
        function() { $(this).css('transform', 'scale(1.03)'); },
        function() { $(this).css('transform', 'scale(1)'); }
    );
}

function filterCourses() {
    const search = $('#searchInput').val().toLowerCase();
    const category = $('#categoryFilter').val();
    const level = $('#levelFilter').val();
    const price = $('#priceFilter').val();
    const type = $('#typeFilter').val();
    let filtered = mockCourses.filter(course => {
        const matchesSearch = course.title.toLowerCase().includes(search) || course.description.toLowerCase().includes(search);
        const matchesCategory = category === 'all' || course.category === category;
        const matchesLevel = level === 'all' || course.level === level;
        const matchesType = type === 'all' || course.type === type;
        let matchesPrice = true;
        if (price === 'free') matchesPrice = course.price === 0;
        else if (price === 'paid') matchesPrice = course.price > 0;
        else if (price === 'under-50') matchesPrice = course.price > 0 && course.price < 50;
        else if (price === '50-100') matchesPrice = course.price >= 50 && course.price <= 100;
        else if (price === 'over-100') matchesPrice = course.price > 100;
        return matchesSearch && matchesCategory && matchesLevel && matchesType && matchesPrice;
    });
    renderCourses(filtered);
}

$(document).ready(function() {
    renderCourses(mockCourses);
    $('#searchInput, #categoryFilter, #levelFilter, #priceFilter, #typeFilter').on('input change', filterCourses);
});
</script>
@endsection 