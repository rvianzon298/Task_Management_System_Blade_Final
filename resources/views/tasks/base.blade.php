@extends('layouts.app')

@section('contents')

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other meta tags and CSS links -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thick-border {
            border: 3px solid #dee2e6; /* You can adjust the thickness and color as needed */
        }
    </style>
</head>

<body>

    <div class="container text-center">
        <h2 class="font-bold text-2xl ml-3">Dashboard</h2>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card thick-border">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card thick-border">
                    <div class="card-body">
                        <h5 class="card-title">Assigned Tasks</h5>
                        <p class="card-text">{{ $totalAssignedTasks }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card thick-border">
                    <div class="card-body">
                        <h5 class="card-title">Completed Tasks</h5>
                        <p class="card-text">{{ $totalCompletedTasks }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your other content here -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
@endsection
