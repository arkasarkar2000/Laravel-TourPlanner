<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

    <div class="container-fluid">
        <div class="row">
            <main class="ms-sm-auto px-md-4">
                <div class="container">
                    <h2 class="my-4">User Listing</h2>
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                {{-- <th>Role</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $serialNumber = $userss->firstItem();
                            @endphp
                            @foreach($userss as $key=>$user)
                            <tr>
                                <td>{{$serialNumber}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{$user->user_roles}}</td>
                                {{-- <td>
                                    {{ $user->role == 0 ? 'Admin' : 'User' }}
                                </td> --}}
                                <td>
                                <a href="{{ route('user.edit', ['id' => $user->id]) }}"><button type="button" class="btn btn-info btn-sm">Update</button></a>
                                <a href="{{ route('user.delete', ['id' => $user->id]) }}"><button type="button" class="btn btn-danger btn-sm">Delete</button></a>
                                </td>
                                @php
                                    $serialNumber++;
                                @endphp
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$userss->links()}}
                </div>

                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/')}}/add-user" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="admin" id="admin" name="role" onclick="toggleCheckboxes(this)">
                                            <label class="form-check-label" for="admin">Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="user" id="user" name="role" onclick="toggleCheckboxes(this)">
                                            <label class="form-check-label" for="user">User</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addTripModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add Trip Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/')}}/add-trip" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Trip To:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="days" class="form-label">Total Days & Nights: </label>
                                        <input type="text" class="form-control" id="days" name="days" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fare" class="form-label">Total Fare: </label>
                                        <input type="text" class="form-control" id="fare" name="fare" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="from" class="form-label">From: </label>
                                        <input type="date" class="form-control" id="from" name="from" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="to" class="form-label">To: </label>
                                        <input type="date" class="form-control" id="to" name="to" required>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label for="selectBox">Select Multiple Options:</label>
                                        <select id="selectBox" class="form-control" multiple name="members[]">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                        </div> --}}
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
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
