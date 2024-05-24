@extends('layouts.app')

@section('contents')
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other meta tags and CSS links -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="container text-center">
        <h2 class="font-bold text-2xl ml-3">Completed Tasks</h2>
        <br>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Completion Date</th>
                <th>Assigned To</th>
                <th>Assigned By</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Actions</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
            @foreach ($completedTasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->completed_at }}</td>
                <td>{{ optional($task->assignedUser)->name }}</td>
                <td>Admin</td>
                <td>
                    @if (strtotime($task->completed_at) <= strtotime($task->due_date))
                        <span class="badge badge-success">On Time</span>
                    @else
                        <span class="badge badge-danger">Late</span>
                    @endif
                </td>
                <td>{{ $task->remarks }}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRemarksModal{{ $task->id }}">
                        Add Remarks
                    </button>
                    <!-- Remarks Modal -->
                    <div class="modal fade" id="addRemarksModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="addRemarksModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addRemarksModalLabel">Add Remarks</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control" id="remarksTextarea{{ $task->id }}" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveRemarks({{ $task->id }})">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <div>
            Showing {{ $completedTasks->firstItem() }} to {{ $completedTasks->lastItem() }} of {{ $completedTasks->total() }} results
        </div>
        <div class="d-flex justify-content-end">
            {{ $completedTasks->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function saveRemarks(taskId) {
        console.log("Saving remarks for task ID:", taskId); // Debug: Check if function is invoked and taskId is correct

        var remarks = $('#remarksTextarea' + taskId).val();
        console.log("Remarks:", remarks); // Debug: Check the remarks being sent in the AJAX request

        // Send AJAX request to save remarks
        $.ajax({
            url: '/save-remarks/' + taskId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                remarks: remarks
            },
            success: function(response) {
                // Handle success response
                console.log("Success:", response); // Debug: Log the success response
                // Close the modal
                $('#addRemarksModal' + taskId).modal('hide');
            },
            error: function(xhr) {
                // Handle error response
                console.log("Error:", xhr.responseText); // Debug: Log the error response
            }
        });
    }
</script>

</body>

</html>
@endsection
