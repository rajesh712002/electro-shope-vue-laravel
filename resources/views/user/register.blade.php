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
                         <li class="breadcrumb-item"><a class="white-text" href="{{ route('userdeshboard') }}">Home</a>
                         </li>
                         <li class="breadcrumb-item">Register</li>
                     </ol>
                 </div>
             </div>
         </section>

         <section class=" section-10">
             <div class="container">
                 <div class="login-form">
                     <form action="{{ route('userstore') }}" method="post">
                         @csrf
                         <h4 class="modal-title">Register Now</h4><br>
                         <div>
                             <h5>Name</h5>
                         </div>
                         <div class="form-group">
                             <input type="text" name="name" id="name"
                                 class="@error('name') is-invalid
                                    @enderror form-control"
                                 value="{{ old('name') }}" placeholder="Name">
                             @error('name')
                                 <p class="invalid-feedback">{{ $message }}</p>
                             @enderror
                         </div>

                         <div>
                             <h5>Email</h5>
                         </div>
                         <div class="form-group">
                             <input type="email" name="email" id="email"
                                 class="@error('email') is-invalid
                                    @enderror form-control"
                                 value="{{ old('email') }}" placeholder="Enter Email">
                             @error('email')
                                 <p class="invalid-feedback">{{ $message }}</p>
                             @enderror
                         </div>

                         <div>
                             <h5>Mobile No</h5>
                         </div>
                         <div class="form-group">
                             <input type="text" name="phone" id="phone"
                                 class="@error('phone') is-invalid
                                    @enderror form-control"
                                 value="{{ old('phone') }}" placeholder="Enter Mobile No">
                             @error('phone')
                                 <p class="invalid-feedback">{{ $message }}</p>
                             @enderror
                         </div>

                         <div>
                             <h5>Password</h5>
                         </div>
                         <div class="form-group">
                             <input type="password" name="password" id="password"
                                 class="@error('password') is-invalid
                                    @enderror form-control"
                                 value="{{ old('password') }}" placeholder="Enter Password">
                             @error('password')
                                 <p class="invalid-feedback">{{ $message }}</p>
                             @enderror
                         </div>

                         <div>
                             <h5>Confirm Pasword</h5>
                         </div>
                         <div class="form-group">
                             <input type="password" class="form-control" placeholder="Confirm Password" id="cpassword"
                                 name="cpassword">
                         </div><br>
                         <div class="form-group small">
                             <a href="#" class="forgot-link">Forgot Password?</a>
                         </div> <br>
                         <button type="submit" id="submit" class="btn btn-dark btn-block btn-lg"
                             value="Register">Register</button>
                     </form>
                     <div class="text-center small">Already have an account? <a href="{{ route('userlogin') }}">Login
                             Now</a></div>
                 </div>
             </div>
         </section>
     </main>
 </body>

 </html>
 {{-- @include('user.includes.footer'); --}}
