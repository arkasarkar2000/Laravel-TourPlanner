<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}/home">Home</a>
                    </li>
                    @if(Auth::user()->role == 0)
                    <li class="nav-item">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                    </li>
                    @endif
                    @if(Auth::user()->role == 0)
                    <li class="nav-item">
                        <button class="btn btn-info mx-3" data-bs-toggle="modal" data-bs-target="#addTripModal">Create Trip</button>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{url('/')}}/logout-user">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="my-4">Edit Trip</h2>
        <form action="{{ route('trip.update', ['id' => $trip->id]) }}" method="POST">
            @csrf
            @method('PUT') 
            <div class="mb-3">
                <label for="name" class="form-label">Trip To:</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{$trip->trip_to}}">
            </div>
    
            <div class="mb-3">
                <label for="days" class="form-label">Total Days & Nights: </label>
                <input type="text" class="form-control" id="days" name="days" required value="{{$trip->total_days}}">
            </div>
    
            <div class="mb-3">
                <label for="fare" class="form-label">Total Fare: </label>
                <input type="text" class="form-control" id="fare" name="fare" required value="{{$trip->total_fare}}">
            </div>
    
            <div class="mb-3">
                <label for="from" class="form-label">From: </label>
                <input type="date" class="form-control" id="from" name="from" required value="{{$trip->from}}">
            </div>
    
            <div class="mb-3">
                <label for="to" class="form-label">To: </label>
                <input type="date" class="form-control" id="to" name="to" required value="{{$trip->to}}">
            </div>

            <div class="mb-3">
                <label for="selectBox">Select Multiple Options:</label>
                <select id="selectBox" class="form-control" multiple name="members[]" value="{{$trip->members}}">
                   @foreach ($users as $user )
                   @php
                   $selected = in_array($user->name, explode(',', $trip->members));
               @endphp
                       <option value="{{ $user->name }}" {{ $selected ? 'selected' : '' }}>{{$user->name}}</option>
                   @endforeach
                </select>
                </div>
    
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</body>
</html>


