@extends('layouts.app')

@section('contents')
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other meta tags and CSS links -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container text-center">
        <h2 class="font-bold text-2xl ml-3">Task List</h2>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <br>
                <a href="{{ route('tasks.create') }}" class="btn btn-warning mb-3">Create Task</a>
            </div>
            <div class="col-md-6">
                <div class="row justify-content-end">
                    <div class="col-md-4 col-sm-6">
                        <h9>&nbsp;Filter by Priority:</h9>
                        <br>
                        <select class="form-control" id="priorityFilter">
                            <option value="">All</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h9>&nbsp;Filter by Status:</h9>
                        <br>
                        <select class="form-control" id="statusFilter">
                            <option value="">All</option>
                            <option value="in_progress">In Progress</option>
                            <option value="late">Late</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="container">

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr class="task-row" data-priority="{{ $task->priority }}" data-status="{{ strtolower(str_replace(' ', '_', $task->status)) }}">
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ optional($task->assignedUser)->name }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        @if (!$task->completed)
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @endif

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
            </div>
            <div class="d-flex justify-content-end">
                {{ $tasks->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            function filterTasks() {
                var selectedPriority = $('#priorityFilter').val();
                var selectedStatus = $('#statusFilter').val();
                console.log('Selected Priority:', selectedPriority);
                console.log('Selected Status:', selectedStatus);

                $('.task-row').hide();

                $('.task-row').filter(function() {
                    var priorityMatch = selectedPriority === '' || $(this).data('priority') === selectedPriority;
                    var statusMatch = selectedStatus === '' || $(this).data('status') === selectedStatus;
                    console.log('Task:', $(this).find('td').first().text(), 'Priority Match:', priorityMatch, 'Status Match:', statusMatch);
                    return priorityMatch && statusMatch;
                }).show();
            }

            $('#priorityFilter').change(filterTasks);
            $('#statusFilter').change(filterTasks);
        });
    </script>
</body>

</html>
@endsection
