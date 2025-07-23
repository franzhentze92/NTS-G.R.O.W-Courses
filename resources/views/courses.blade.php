@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="max-width: 1400px;">
    <div class="mb-8 text-center" style="background: transparent;">
        <h2 class="fw-bold mb-2" style="font-size: 2rem; background: transparent;">G.R.O.W Learning Center</h2>
        <p class="lead text-muted mx-auto" style="max-width: 700px; background: transparent;">
            Master sustainable agriculture through our comprehensive courses designed by industry experts. 
            From soil health to planetary wellness, advance your knowledge and skills.
        </p>
        <div class="my-3"></div>
    </div>
    <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-4">
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
                    <option value="business-marketing">Business & Marketing</option>
                    <option value="innovation">Innovation</option>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <select id="levelFilter" class="form-select">
                    <option value="all">All Levels</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
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
                    <option value="theory">Theory</option>
                    <option value="practice">Practice</option>
                    <option value="mixed">Mixed</option>
                </select>
            </div>
        </div>
        <!-- Results count -->
        <div class="text-muted small mb-3" id="resultsCount">
            Showing <span id="shownCount">0</span> of <span id="totalCount">0</span> courses
        </div>

        <!-- Course Grid -->
        <div class="row g-4" id="coursesList">
            @foreach($courses as $course)
                <div class="col-12 col-md-6 col-lg-4 course-card" 
                     data-category="{{ $course->category }}" 
                     data-level="{{ $course->level }}" 
                     data-type="{{ $course->type }}" 
                     data-price="{{ $course->price === 0 ? 'free' : ($course->price < 50 ? 'under-50' : ($course->price <= 100 ? '50-100' : 'over-100')) }}"
                     data-title="{{ strtolower($course->title) }}"
                     data-description="{{ strtolower($course->description) }}">
                    <div class="card h-100 shadow-sm border-0" style="background: #fff; border-radius: 18px; transition: transform 0.2s; cursor: pointer;">
                        <div class="position-relative" style="height: 120px; border-top-left-radius: 18px; border-top-right-radius: 18px; overflow: hidden;">
                            <img src="{{ $course->cover_image ?: '/how-to-thumbnails-languages/grow-courses.jpeg' }}" class="card-img-top h-100 w-100 object-fit-cover" alt="Course image" style="object-fit: cover;">
                        </div>
                        <div class="card-body pb-2 pt-2">
                            <div class="d-flex align-items-center mb-1 gap-2">
                                <span class="badge" style="background: #F2F4F7; color: #344054; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ str_replace('-', ' ', $course->category) }}</span>
                                <span class="badge" style="background: #D1FADF; color: #12B76A; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $course->level }}</span>
                                <span class="badge" style="background: #FEF9C3; color: #FEC84B; font-weight: 500; border-radius: 999px; font-size: 0.85em;">{{ $course->type }}</span>
                            </div>
                            <h5 class="card-title mb-1 mt-2" style="font-size: 1.08em; line-height: 1.2; min-height: 2.2em; font-weight: bold; color: #101828;">{{ $course->title }}</h5>
                            <div class="d-flex align-items-center gap-3 mb-2" style="color: #667085; font-size: 0.97em;">
                                <i class="bi bi-clock"></i> <span>{{ $course->duration_hours }}h</span>
                                <i class="bi bi-journal-text"></i> <span>{{ $course->lessons_count }} lessons</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                @if($course->instructor)
                                    <img src="{{ $course->instructor->avatar ?: 'https://via.placeholder.com/28' }}" class="rounded-circle me-2 border" width="28" height="28" alt="Instructor">
                                    <span style="font-weight: 600; color: #344054;">Instructor:</span>
                                    <span class="ms-1" style="color: #344054;">{{ $course->instructor->name }}</span>
                                @else
                                    <span style="font-weight: 600; color: #344054;">Instructor:</span>
                                    <span class="ms-1" style="color: #344054;">TBD</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="fw-bold" style="font-size: 1em; color: #101828;">{{ $course->formatted_price }}</span>
                                <a href="/courses/{{ $course->id }}" class="btn d-flex align-items-center gap-2 px-3 py-1" style="background: #8cb33a; color: #fff; border-radius: 8px; font-weight: 600; border: 1.5px solid #8cb33a; font-size: 1em;">
                                    <i class="bi bi-mortarboard"></i> Enroll
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allCourses = document.querySelectorAll('.course-card');
    let filteredCourses = allCourses;

    // Filter and search functionality
    function filterCourses() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const levelFilter = document.getElementById('levelFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const priceFilter = document.getElementById('priceFilter').value;

        console.log('Filtering with:', { searchTerm, categoryFilter, levelFilter, typeFilter, priceFilter });

        filteredCourses = Array.from(allCourses).filter(function(card) {
            const title = card.dataset.title;
            const description = card.dataset.description;
            const category = card.dataset.category;
            const level = card.dataset.level;
            const type = card.dataset.type;
            const price = card.dataset.price;

            console.log('Course data:', { title, category, level, type, price });

            const matchesSearch = searchTerm === '' || title.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = categoryFilter === 'all' || category === categoryFilter;
            const matchesLevel = levelFilter === 'all' || level === levelFilter;
            const matchesType = typeFilter === 'all' || type === typeFilter;
            const matchesPrice = priceFilter === 'all' || price === priceFilter;

            const isMatch = matchesSearch && matchesCategory && matchesLevel && matchesType && matchesPrice;
            console.log('Match result:', isMatch, { matchesSearch, matchesCategory, matchesLevel, matchesType, matchesPrice });

            return isMatch;
        });

        // Show/hide courses
        allCourses.forEach(card => card.style.display = 'none');
        filteredCourses.forEach(card => card.style.display = 'block');

        // Update results count
        const visibleCount = filteredCourses.length;
        document.getElementById('shownCount').textContent = visibleCount;
        document.getElementById('totalCount').textContent = allCourses.length;
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', filterCourses);
    document.getElementById('categoryFilter').addEventListener('change', filterCourses);
    document.getElementById('levelFilter').addEventListener('change', filterCourses);
    document.getElementById('typeFilter').addEventListener('change', filterCourses);
    document.getElementById('priceFilter').addEventListener('change', filterCourses);

    // Card hover effect
    allCourses.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.03)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Initialize
    console.log('Initializing filters...');
    console.log('Total courses found:', allCourses.length);
    filterCourses();
});
</script>
@endsection 