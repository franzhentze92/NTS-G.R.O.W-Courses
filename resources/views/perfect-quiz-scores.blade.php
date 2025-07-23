<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfect Course Completions - First 25 Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: linear-gradient(135deg, #8cb33a 0%, #6c8c2a 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #8cb33a;
            color: white;
            border: none;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge-perfect {
            background-color: #8cb33a;
            color: white;
            font-weight: 600;
        }
        .stats-card {
            background: linear-gradient(135deg, #8cb33a 0%, #6c8c2a 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2">
                        <i class="bi bi-trophy-fill me-3"></i>
                        Perfect Course Completions
                    </h1>
                    <p class="mb-0">First 25 users who completed entire courses with 100% quiz scores</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex align-items-center justify-content-md-end">
                        <i class="bi bi-people-fill me-2" style="font-size: 2rem;"></i>
                        <div>
                            <div class="h4 mb-0" id="totalCount">0</div>
                            <small>Perfect Completions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>User Name</th>
                                        <th>Course</th>
                                        <th>Quiz Score</th>
                                        <th>Lessons Completed</th>
                                        <th>Quiz Time</th>
                                        <th>Course Completed At</th>
                                    </tr>
                                </thead>
                                <tbody id="scoresTableBody">
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2 text-muted">Loading perfect completions...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch perfect course completions
        fetch('/perfect-course-completions')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayCompletions(data.data);
                    document.getElementById('totalCount').textContent = data.count;
                } else {
                    showError('Failed to load data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Error loading data');
            });

        function displayCompletions(completions) {
            const tbody = document.getElementById('scoresTableBody');
            tbody.innerHTML = '';

            if (completions.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                            <p class="mt-2 text-muted">No perfect course completions found yet</p>
                        </td>
                    </tr>
                `;
                return;
            }

            completions.forEach((completion, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="fw-bold">${index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 0.8rem;"></i>
                            </div>
                            <span class="fw-semibold">${completion.user_name}</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">${completion.course_title}</span>
                    </td>
                    <td>
                        <span class="badge badge-perfect">
                            <i class="bi bi-check-circle me-1"></i>
                            ${completion.score}%
                        </span>
                    </td>
                    <td>
                        <span class="text-muted">${completion.completed_lessons}/${completion.total_lessons}</span>
                    </td>
                    <td>
                        ${completion.time_taken ? formatTime(completion.time_taken) : '<span class="text-muted">N/A</span>'}
                    </td>
                    <td>
                        <span class="text-muted">${formatDateTime(completion.submitted_at)}</span>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function formatTime(seconds) {
            if (seconds < 60) {
                return `${seconds}s`;
            } else if (seconds < 3600) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}m ${remainingSeconds}s`;
            } else {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                return `${hours}h ${minutes}m`;
            }
        }

        function formatDateTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function showError(message) {
            const tbody = document.getElementById('scoresTableBody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                        <p class="mt-2 text-danger">${message}</p>
                    </td>
                </tr>
            `;
        }
    </script>
</body>
</html> 