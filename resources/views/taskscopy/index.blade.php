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

        .card-text {
            text-align: left;
        }

        .remaining-time {
            font-size: 1rem;
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>

<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-bold text-2xl ml-3">Assigned Tasks</h2>
            </div>
        </div>
            <div class="col-md-4">
                <div class="form-inline">
                    <label for="priorityFilter" class="mr-2">Filter by Priority:</label>
                    <select class="form-control" id="priorityFilter">
                        <option value="">All</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <div class="container">
        <div class="row" id="taskCards">
            @foreach ($tasks as $task)
            @php
            $status = 'In Progress';
            $now = now();
            if ($task->completed) {
                $status = 'Completed';
            } elseif ($task->due_date < $now) {
                $status = 'Late';
            }
            @endphp
            <div class="col-md-4 mb-4 task-card" data-priority="{{ $task->priority }}">
                <div class="card">
                    <div class="card-header">
                        <br>
                        <h6 class="card-title text-center">{{ $task->title }}</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Status:</strong> {{ $status }}</p>
                        <p class="card-text"><strong>Description:</strong> {{ $task->description }}</p>
                        <p class="card-text"><strong>Priority:</strong> {{ $task->priority }}</p>
                        <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                        <p class="card-text"><strong>Remaining Time:</strong> <span class="remaining-time" id="remaining-time-{{ $task->id }}"></span></p>
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
    <script>
        $(document).ready(function() {
            $('#priorityFilter').change(function() {
                var selectedPriority = $(this).val();
                if (selectedPriority === '') {
                    $('.task-card').show();
                } else {
                    $('.task-card').hide();
                    $('.task-card[data-priority="' + selectedPriority + '"]').show();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            @foreach ($tasks as $task)
                updateRemainingTime({{ $task->id }}, '{{ $task->due_date }}');
            @endforeach
        });

        function updateRemainingTime(taskId, dueDate) {
            const remainingTimeElement = document.getElementById(`remaining-time-${taskId}`);
            const dueDateTime = new Date(dueDate).getTime();
            const now = new Date().getTime();
            let remainingTime = dueDateTime - now;

            if (remainingTime <= 0) {
                remainingTimeElement.textContent = 'Past due';
            } else {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                remainingTime %= (1000 * 60 * 60 * 24);
                const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                remainingTime %= (1000 * 60 * 60);
                const minutes = Math.floor(remainingTime / (1000 * 60));
                remainingTime %= (1000 * 60);
                const seconds = Math.floor(remainingTime / 1000);
                remainingTimeElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }

            setTimeout(() => updateRemainingTime(taskId, dueDate), 1000);
        }
    </script>
</body>

</html>
@endsection
