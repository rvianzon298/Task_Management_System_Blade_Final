@extends('layouts.user')
@section('contents')

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #14202e;
            color: #fff;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            padding: 5px;
        }
        .card-body {
            padding: 50px;

        }
        .card-footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: right;
        }

        .btn-complete {
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            transition: background-color 0.3s;
        }
        .btn-complete:hover {
            background-color: #218838;
        }
        .card-text{
            text-align: left;
        }

    </style>


</head>

<body>
    <br>
    <div class="container">
        <h2 class="font-bold text-2xl ml-3">Assigned Tasks</h2>
        <br>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <div class="container">
        <div class="row">
            @foreach ($tasks as $task)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <br>
                        <h6 class="card-title text-center">{{ $task->title }}</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Description:</strong> {{ $task->description }}</p>
                        <p class="card-text"><strong>Priority:</strong> {{ $task->priority }}</p>
                        <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                    </div>
                    <div class="card-footer text-right">
                        @if (!$task->completed)
                        <form action="{{ route('taskscopy.complete', $task->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-complete btn-sm">
                                <i class="fa fa-check"></i> Complete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
@endsection
