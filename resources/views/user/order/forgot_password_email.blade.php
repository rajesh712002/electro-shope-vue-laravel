{{-- @include('user.includes.header') --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/video-js.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo rand(111, 999); ?>" /> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
    rel="stylesheet">

<!-- Fav Icon -->
<link rel="shortcut icon" type="image/x-icon" href="#" />
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<main>


    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    {{-- @include('user.includes.account_panel') --}}
                </div>
                <div class="col-md-9">
                    <form id="ForgotPasswordForm" name="ForgotPasswordForm"
                        action="{{ route('user.processForgotPasswordEmail') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                            </div>

                            <div class="card-body p-4">
                                <div class="row">
                                    <input type="hidden" value="{{ $token }}" name="token" id="token">
                                    <div class="mb-3">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" id="new_password"
                                            value="{{ old('new_password') }}" placeholder="New Password"
                                            class="@error('new_password') is-invalid
                                    @enderror form-control">
                                        @error('new_password')
                                            {{-- <p class="invalid-feedback">{{ $message }}</p> --}}
                                        @enderror
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            value="{{ old('confirm_password') }}" placeholder="Confirm New Password"
                                            class="@error('confirm_password') is-invalid
                                    @enderror form-control">
                                        @error('confirm_password')
                                            {{-- <p class="invalid-feedback">{{ $message }}</p> --}}
                                        @enderror
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" name="submit" id="submit" class="btn btn-dark">Save
                                            Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('user_assets/js/ajx.js') }}"></script>

{{-- @include('user.includes.footer') --}}
