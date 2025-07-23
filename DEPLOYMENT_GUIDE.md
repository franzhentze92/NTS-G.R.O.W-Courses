# Education Courses Platform - Deployment Guide

## Overview
This is a Laravel-based Learning Management System (LMS) designed for integration into the NTS G.R.O.W platform. It provides core learning functionality including course viewing, lesson navigation, quiz system, and progress tracking. Admin functionality will be developed separately in the future.

## 📄 Pages for NTS G.R.O.W Platform Integration

### **Core Learning Pages (To Be Integrated):**
- `/` - Home/Welcome page with course overview
- `/courses` - Course catalog/browse page with filtering
- `/courses/{id}` - Individual course detail page with enrollment
- `/courses/{courseId}/lessons/{lessonId}` - Interactive lesson viewer with video/reading content
- `/perfect-quiz-scores` - Quiz scoring and results page for performance tracking
- `/perfect-course-completions` - Course completion tracking and certificates

### **API Endpoints (For Integration):**
- `/test/quiz-questions/{lessonId}` - Quiz questions API endpoint for dynamic quiz loading
- `/courses/{course}/lessons/{lesson}/complete` - Lesson completion tracking
- `/courses/{course}/lessons/{lesson}/quiz` - Quiz submission and scoring

### **Admin Pages (Future Implementation - NOT for current integration):**
*Note: These admin pages will be developed separately and are NOT part of the current NTS G.R.O.W integration. Courses will be managed directly through database seeding and scripts.*

- `/admin/courses` - Course management dashboard (future)
- `/admin/course-create` - Create new course page (future)
- `/admin/course-edit/{id}` - Edit course page (future)
- `/admin/instructors` - Instructor management page (future)
- `/admin/user-progress` - User progress tracking page (future)

### **Functional Features:**
- Course browsing and filtering
- Chapter-based lesson navigation
- Video and reading lesson types
- Interactive quiz system with scoring
- Progress tracking and completion status
- Quiz results and performance analytics
- Course completion certificates
- Responsive mobile-friendly design

## Features Included
- ✅ Course browsing and management
- ✅ Chapter-based lesson organization
- ✅ Video and reading lesson types
- ✅ Interactive quiz system with scoring
- ✅ Quiz results and scoring page
- ✅ Progress tracking
- ✅ Course completion tracking
- ✅ Responsive design
- ✅ MySQL database integration

## Installation Steps

### 1. Server Requirements
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js (for asset compilation)

### 2. Database Setup
1. Create a MySQL database (e.g., `education_courses`)
2. Update `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=education_courses
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. Run migrations and seed the database with sample data:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *This will create all necessary tables and populate them with sample course data, including the Soil Therapy Workshop course with 13 lessons and 20 quiz questions.*

### 3. Application Setup
```bash
# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Run migrations and seed database
php artisan migrate:fresh --seed

# Install and compile frontend assets
npm install
npm run build
```

### 4. File Permissions
```bash
# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### 5. Video Files
- Place video files in `public/videos/` directory
- Current videos needed:
  - `chapter-1-video.mp4`
  - `chapter-2-video.mp4`
  - `chapter-3-video.mp4`
  - `chapter-4-video.mp4`

## Database Structure

### Tables Created:
- `users` - User accounts
- `instructors` - Course instructors
- `courses` - Course information
- `lessons` - Course lessons (13 total)
- `quiz_questions` - Quiz questions (20 total)
- `enrollments` - User course enrollments
- `lesson_progress` - User progress tracking

### Sample Data Included:
- 1 test user (test@example.com / password)
- 1 instructor (Graeme Sait)
- 1 course (Soil Therapy Workshop)
- 13 lessons organized in 4 chapters
- 20 quiz questions for final assessment

## Routes

### Main Routes:
- `/` - Home page
- `/courses` - Course catalog
- `/courses/{id}` - Course detail
- `/courses/{courseId}/lessons/{lessonId}` - Lesson viewer
- `/perfect-quiz-scores` - Quiz scoring and results page
- `/perfect-course-completions` - Course completion tracking

## Configuration Notes

### Environment Variables to Update:
- `APP_URL` - Set to your domain
- `DB_*` - Database connection details
- `MAIL_*` - Email configuration (if needed)

### Security Considerations:
- Update `APP_DEBUG=false` in production
- Configure proper file permissions
- Set up HTTPS
- Configure proper session handling

## Development vs Production

### Current Status:
- ✅ Development ready
- ✅ Testing ready
- ⚠️ Needs authentication system for production
- ⚠️ Needs payment processing for commercial use
- ⚠️ Needs admin panel for course management

### Recommended Next Steps:
1. Add user authentication (Laravel Breeze/Jetstream)
2. Add payment processing (Stripe/PayPal)
3. Build admin panel for course management
4. Add email notifications
5. Configure production hosting

## Support
For technical support or questions about this deployment, contact the development team.

---
**Note**: This application is ready for development and testing. Additional features are needed for commercial production use. 