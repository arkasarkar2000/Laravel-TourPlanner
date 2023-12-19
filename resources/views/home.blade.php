<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
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
                        <a class="nav-link" href="{{ url('/') }}/home">Home</a>
                    </li>
                    {{-- @if (in_array('superadmin', $userRoles) || in_array('admin', $userRoles)) --}}
                    <li class="nav-item">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">Add
                            User</button>
                    </li>
                    <button class="btn btn-info mx-3" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add
                        Roles</button>
                    <li class="nav-item">
                        <button class="btn btn-info mx-3" data-bs-toggle="modal" data-bs-target="#addTripModal">Create
                            Trip</button>
                    </li>
                    {{-- @endif --}}
                </ul>
                {{-- @php
                    dd("hi");
                @endphp --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/') }}/logout-user">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <nav id="sidebar" class="bg-light">
        <div class="container-fluid">
            <div class="d-flex flex-column align-items-center">
                <h2 class="my-4">Sidebar</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}/users">Listed Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <main class="ms-sm-auto px-md-4">

                <div class="container">
                    <h2 class="my-4">Trips Listing</h2>
                    <a href="{{url('trips_export?input_search='.$request->input_search)}}" class="btn btn-sm btn-dark mb-3">Export</a>
                    <form action="{{route('trip.index')}}" method="get" id="usersearch">
                        <input type="text" name="input_search" class="form-control mb-3 col-lg-4"
                            placeholder="Search..."
                            value="{{ !empty($request->input_search) ? $request->input_search : '' }}">
                        <div class="col-lg-2">
                            <button class="btn search-btn w-100 btn-info mb-3" type="submit" name="submit">Search
                            </button>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Destination</th>
                                <th>Total Fare</th>
                                <th>Total Days & Nights</th>
                                <th>Date of Trip</th>
                                <th>Members</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $index = $trips->perPage() * ($trips->currentPage() - 1)
                            @endphp
                            @foreach ($trips as $key => $trip)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $trip->trip_to }}</td>
                                    <td>{{ $trip->total_fare }}</td>
                                    <td>{{ $trip->total_days }}</td>
                                    <td>{{ $trip->from }} - {{ $trip->to }}</td>
                                    <td>
                                        <strong>{{ $trip->members ? $trip->members : 'No members available...' }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('trip.edit', ['id' => $trip->id]) }}"><button type="button"
                                                class="btn btn-info btn-sm">Update</button></a>
                                        <button class="btn btn-danger btn-sm btn-delete"
                                            data-trip-id="{{ $trip->id }}">Delete</button>

                                    </td>
                                </tr>
                                @php
                                $index++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="pagination_user">
                    @if($trips->firstItem() == null || $trips->firstItem() == '')
                    <div class="user_info"> Showing 0 to 0 of {{$trips->total()}} entries </div>
                    @else
                    <div class="user_info"> Showing {{$trips->firstItem()}} to {{$trips->lastItem() }} of {{$trips->total()}} entries </div>
                    @endif
                    <ul class="pagination">
                       {{-- Previous Page Link --}}
                       @if ($trips->onFirstPage())
                       <li class="disabled page-item"><a href="#!" class="page-link"><i class="fa-solid fa-chevron-left"></i></a></li>
                       @else
                       <li class="waves-effect page-item"><a class="page-link" href="{{ $trips->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a></li>
                       @endif
                       @php
                       $link_limit=7;
                       $str = '';
                       if(isset($request->query()['input_search'])){
                       $str .= '&input_search='.$request->query()['input_search'];
                       }
                       @endphp
                       {{-- Page Number Links --}}
                       @for($i=1; $i<=$trips->lastPage(); $i++)
                             @php
                                $half_total_links = floor($link_limit / 2);
                                $from = $trips->currentPage() - $half_total_links;
                                $to = $trips->currentPage() + $half_total_links;
                                if ($trips->currentPage() < $half_total_links) {
                                   $to += $half_total_links - $trips->currentPage();
                                }
                                if ($trips->lastPage() - $trips->currentPage() < $half_total_links) {
                                   $from -= $half_total_links - ($trips->lastPage() - $trips->currentPage()) - 1;
                                }
                             @endphp
                             @if ($from < $i && $i < $to)
                                <li class="{{ ($trips->currentPage() == $i) ? ' active page-item' : 'waves-effect page-item' }}"><a class="page-link" href="?page={{$i}}{{$str}}">{{$i}}</a></li>
                             @endif
                       @endfor
                       {{-- Next Page Link --}}
                       @if ($trips->hasMorePages())
                       <li class="waves-effect page-item"><a class="page-link" href="{{ $trips->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a></li>
                       @else
                       <li class="disabled page-item"><a href="#!" class="page-link"><i class="fa-solid fa-chevron-right"></i></a></li>
                       @endif
                    </ul>
                 </nav>

                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/add-user') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">Advance</label>
                                        <input type="number" class="form-control" id="advance" name="advance">
                                    </div>
                                    <div class="mb-3">
                                        <label for="roles" class="form-label">Roles</label>
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $role->role_name }}" name="roles[]"
                                                    id="{{ $role->role_name }}">
                                                <label class="form-check-label"
                                                    for="{{ $role->role_name }}">{{ $role->role_name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="addTripModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add Trip Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/') }}/add-trip" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Trip To:</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="days" class="form-label">Total Days & Nights: </label>
                                        <input type="text" class="form-control" id="days" name="days"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fare" class="form-label">Total Fare: </label>
                                        <input type="text" class="form-control" id="fare" name="fare"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="from" class="form-label">From: </label>
                                        <input type="date" class="form-control" id="from" name="from"
                                            required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="to" class="form-label">To: </label>
                                        <input type="date" class="form-control" id="to" name="to"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectBox">Select Multiple Options:</label>
                                        <select id="selectBox" class="form-control" multiple name="members[]">
                                            @foreach ($users as $user)
                                                <option>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Create Roles</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/') }}/add-role" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
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
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
