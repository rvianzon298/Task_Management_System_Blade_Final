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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($completedTasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->completed_at }}</td>
                <td>{{ $task->assignedUser->name }}</td>
                <td>
                    @if (strtotime($task->completed_at) <= strtotime($task->due_date))
                        <span class="badge badge-success">On Time</span>
                    @else
                        <span class="badge badge-danger">Late</span>
                    @endif
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
</body>

</html>
@endsection
