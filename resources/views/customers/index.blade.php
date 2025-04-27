@extends('layouts.admin_app')

{{-- Customize layout sections --}}
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}
@section('content_body')

<h1>Customer Listing</h1>
<div id="customer-list">
    <table id="user-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Postcode</th>
                <th>Gender</th>
                <th>State</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="user_id">
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label>Contact Number</label>
                <input type="text" class="form-control" name="contact_number">
            </div>
            <div class="mb-3">
                <label>Postcode</label>
                <input type="text" class="form-control" name="postcode">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" id="gender-male" name="gender_id" value="1">
                <label for="gender-male">Male</label>
                <input type="radio" id="gender-female" name="gender_id" value="2" class="ms-3">
                <label for="gender-female">Female</label>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>

@stop

{{-- Push extra CSS --}}
@push('css')
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

{{-- Push extra scripts --}}
@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> 
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#user-table').DataTable({ 
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/users',
            type: 'GET',
            dataType: 'json',
            dataSrc: '',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
        },
        columns: [
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'email' },
            { data: 'contact_number' },
            { data: 'postcode' },
            { data: 'gender.gender' },
            { data: 'state.name' },
            { data: 'city.name' },
            {
                data: 'id',
                render: function(data, type, row, meta) {
                    return `
            <a href="javascript:void(0);" class="edit-btn" data-id="${data}" title="Edit">
                <i class="fas fa-edit text-primary"></i>
            </a>
            &nbsp;&nbsp;
            <a href="javascript:void(0);" class="delete-user" data-id="${data}" title="Delete">
                <i class="fas fa-trash-alt text-danger"></i>
            </a>
        `;
                },
                orderable: false, 
                searchable: false 
            }
        ]
    });

    $(document).on('click', '.delete-user', function() {
        var userId = $(this).data('id');
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: '/api/users/' + userId,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')
                },
                success: function(response) {
                    alert(response.message);
                    $('#user-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('Error deleting user');
                }
            });
        }
    });

    $('#user-table').on('click', '.edit-btn', function() {
        let userId = $(this).data('id');
        
        $.ajax({
            url: '/api/users/' + userId,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
            success: function(user) {
                $('#editUserModal input[name="first_name"]').val(user.first_name);
                $('#editUserModal input[name="last_name"]').val(user.last_name);
                $('#editUserModal input[name="email"]').val(user.email);
                $('#editUserModal input[name="contact_number"]').val(user.contact_number);
                $('#editUserModal input[name="postcode"]').val(user.postcode);
                $('input[name="gender_id"][value="' + user.gender_id + '"]').prop('checked', true);
                $('#editUserModal input[name="user_id"]').val(user.id); 


                $('#editUserModal').modal('show');
            },
            error: function(xhr) {
                alert('Failed to fetch user details.');
            }
        });
    });

    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();

        let userId = $('#editUserModal input[name="user_id"]').val();
        let formData = {
            first_name: $('#editUserModal input[name="first_name"]').val(),
            last_name: $('#editUserModal input[name="last_name"]').val(),
            email: $('#editUserModal input[name="email"]').val(),
            contact_number: $('#editUserModal input[name="contact_number"]').val(),
            postcode: $('#editUserModal input[name="postcode"]').val(),
            gender_id: $('input[name="gender_id"]:checked').val(),
        };

        var submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);
        var originalButtonHtml = submitButton.html();
        submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

        $.ajax({
            url: '/api/users/' + userId,
            type: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
            data: formData,
            success: function(response) {
                alert(response.message);
                $('#editUserModal').modal('hide');
                $('#user-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Update failed.');
            },
            complete: function() {
                submitButton.prop('disabled', false);
                submitButton.html(originalButtonHtml);
            }
        });
    });
});
</script>
@endpush
