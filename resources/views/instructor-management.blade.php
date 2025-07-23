@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Instructor Management</h1>
    <div class="row">
        <div class="col-lg-7">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="instructorList">
                    <!-- Instructors will be rendered here by jQuery -->
                </tbody>
            </table>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 id="formTitle">Add New Instructor</h5>
                    <form id="instructorForm">
                        <input type="hidden" id="instructorId">
                        <div class="mb-2">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="instructorName" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" id="instructorTitle">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="instructorEmail">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" id="instructorWebsite">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" id="instructorLocation">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" id="instructorBio"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" id="saveInstructorBtn">Add Instructor</button>
                        <button type="button" class="btn btn-secondary ms-2 d-none" id="cancelEditBtn">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Mock data for instructors
let instructors = [
    {
        id: 1,
        name: 'Dr. Jane Smith',
        title: 'Soil Scientist',
        email: 'jane.smith@example.com',
        website: 'https://example.com',
        location: 'Australia',
        bio: 'Dr. Smith has 20 years of experience in soil science and sustainable agriculture.'
    },
    {
        id: 2,
        name: 'Prof. John Doe',
        title: 'Plant Nutritionist',
        email: 'john.doe@example.com',
        website: 'https://example.org',
        location: 'USA',
        bio: 'Prof. Doe is an expert in plant nutrition and advanced growing techniques.'
    }
];

function renderInstructors() {
    const $list = $('#instructorList');
    $list.empty();
    if (instructors.length === 0) {
        $list.append('<tr><td colspan="5" class="text-center">No instructors found.</td></tr>');
        return;
    }
    instructors.forEach(inst => {
        $list.append(`
            <tr>
                <td>${inst.name}</td>
                <td>${inst.title}</td>
                <td>${inst.email}</td>
                <td><a href="${inst.website}" target="_blank">${inst.website}</a></td>
                <td>
                    <button class="btn btn-sm btn-primary me-1 edit-instructor-btn" data-id="${inst.id}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-instructor-btn" data-id="${inst.id}">Delete</button>
                </td>
            </tr>
        `);
    });
}

let editingInstructorId = null;

$(document).ready(function() {
    renderInstructors();
    // Add or edit instructor
    $('#instructorForm').on('submit', function(e) {
        e.preventDefault();
        const newInst = {
            id: editingInstructorId || Date.now(),
            name: $('#instructorName').val(),
            title: $('#instructorTitle').val(),
            email: $('#instructorEmail').val(),
            website: $('#instructorWebsite').val(),
            location: $('#instructorLocation').val(),
            bio: $('#instructorBio').val()
        };
        if (editingInstructorId) {
            const idx = instructors.findIndex(i => i.id === editingInstructorId);
            instructors[idx] = newInst;
        } else {
            instructors.push(newInst);
        }
        renderInstructors();
        this.reset();
        $('#saveInstructorBtn').text('Add Instructor');
        $('#formTitle').text('Add New Instructor');
        $('#cancelEditBtn').addClass('d-none');
        editingInstructorId = null;
    });
    // Edit instructor
    $(document).on('click', '.edit-instructor-btn', function() {
        const id = $(this).data('id');
        const inst = instructors.find(i => i.id === id);
        $('#instructorId').val(inst.id);
        $('#instructorName').val(inst.name);
        $('#instructorTitle').val(inst.title);
        $('#instructorEmail').val(inst.email);
        $('#instructorWebsite').val(inst.website);
        $('#instructorLocation').val(inst.location);
        $('#instructorBio').val(inst.bio);
        $('#saveInstructorBtn').text('Save Changes');
        $('#formTitle').text('Edit Instructor');
        $('#cancelEditBtn').removeClass('d-none');
        editingInstructorId = id;
    });
    // Cancel edit
    $('#cancelEditBtn').on('click', function() {
        $('#instructorForm')[0].reset();
        $('#saveInstructorBtn').text('Add Instructor');
        $('#formTitle').text('Add New Instructor');
        $(this).addClass('d-none');
        editingInstructorId = null;
    });
    // Delete instructor
    $(document).on('click', '.delete-instructor-btn', function() {
        const id = $(this).data('id');
        instructors = instructors.filter(i => i.id !== id);
        renderInstructors();
        if (editingInstructorId === id) {
            $('#instructorForm')[0].reset();
            $('#saveInstructorBtn').text('Add Instructor');
            $('#formTitle').text('Add New Instructor');
            $('#cancelEditBtn').addClass('d-none');
            editingInstructorId = null;
        }
    });
});
</script>
@endsection 