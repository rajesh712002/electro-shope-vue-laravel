@include('user.includes.header')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('usershop')}}">Shop</a></li>
                    <li class="breadcrumb-item"><a class="white-text">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('user.includes.account_panel')
                </div>
                <div class="col-md-9">
                    <form id="ChangePasswordForm" name="ChangePasswordForm" action="{{route('user.showchangePassword')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                            </div>

                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" value="{{ old('old_password') }}"
                                            placeholder="Old Password" class=" is-invalid
                                     form-control">
                                   
                                    <p></p>
                                <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" id="new_password" value="{{ old('new_password') }}"
                                            placeholder="New Password" class="@error('new_password') is-invalid
                                    @enderror form-control">
                                    @error('new_password')
                                    {{-- <p class="invalid-feedback">{{ $message }}</p> --}}
                                @enderror
                                <p></p>
                                <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}"
                                            placeholder="Confirm New Password" class="@error('confirm_password') is-invalid
                                    @enderror form-control">
                                            @error('confirm_password')
                                            {{-- <p class="invalid-feedback">{{ $message }}</p> --}}
                                        @enderror
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" name="submit" id="submit" class="btn btn-dark">Save Password</button>
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

@include('user.includes.footer')
