@include('user.includes.header')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="">My Account</a></li>
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
                    {{-- @dd($user) --}}
                    <form method="POST" id="ProfileUpdateForm" name="ProfileUpdateForm" action="{{route('userchangeProfile')}}">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{$user->name}}"
                                            placeholder="Enter Your Name" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="{{$user->email}}"
                                            placeholder="Enter Your Email" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{$user->phone}}"
                                            placeholder="Enter Your Phone" class="form-control">
                                    </div>

                                    {{-- <div class="mb-3">
                                        <label for="phone">Address</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5"
                                            placeholder="Enter Your Address"></textarea>
                                    </div> --}}

                                    <div class="d-flex">
                                        <button type="submit" name="submit" id="submit"
                                            class="btn btn-dark">Update</button>
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
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>

@include('user.includes.footer')
