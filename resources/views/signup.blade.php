<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Signup</title>
</head>
<body>

    <div class="container">
        <div class="custom-form">
            <h2 class="mb-4">Signup</h2>
    
            <form method="post" action="{{url('/')}}/signup-form">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}">
                    @error('name')
                        <p class="text-danger error">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{old('email')}}">
                    @error('email')
                        <p class="text-danger error">{{ $message }}</p>
                    @enderror
                  
                </div>
    
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <p class="text-danger error">{{ $message }}</p>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            <span>Already Signed Up? <a href="{{url('/')}}/login">Login</a></span>
        </div>
    </div>
    @if(session('success'))
    <div id="successMessage" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>