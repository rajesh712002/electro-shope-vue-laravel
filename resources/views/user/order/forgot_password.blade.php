{{-- @include('user.includes.header'); --}}
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/video-js.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <header class="bg-dark">
                <div class="container">
                    <nav class="navbar navbar-expand-xl" id="navbar">

                    </nav>
                </div>
            </header>

            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('userlogin') }}">Login</a></li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-10">
            <div class="container">
                <div class="login-form">
                    <form action="{{ route('user.processForgetPassword') }}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            @if (Session::has('success'))
                                <div class="col-md-10">
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <h4 class="modal-title">Enter Email For Login</h4>
                        <div class="form-group">
                            <input type="email" name="email" id="email"
                                class="@error('email') is-invalid
                               @enderror form-control"
                                value="{{ old('email') }}" placeholder="Enter Email">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div class="form-group">
                            <input type="password" name="password" id="password"
                                class="@error('password') is-invalid
                                    @enderror form-control"
                                        value="{{ old('password') }}" placeholder="Enter Password">
                                        @error('password')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                        </div> --}}

                        <div class="form-group small">
                            <a href="{{ route('userlogin') }}" class="forgot-link">Login</a>
                        </div>
                        <input type="submit" class="btn btn-dark btn-block btn-lg" value="Send">
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>

</html>
{{-- @include('user.includes.footer'); --}}
