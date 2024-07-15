 @include('user.header');
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item">Register</li>
                    </ol>
                </div>
            </div>
        </section>
    
        <section class=" section-10">
            <div class="container">
                <div class="login-form">    
                    <form action="{{route('userstore')}}" method="post">
                        @csrf
                        <h4 class="modal-title">Register Now</h4><br>
                        <div>
                            <h5>Name</h5>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name">
                        </div>

                        <div>
                            <h5>Email</h5>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Email Address" id="email" name="email">
                        </div>

                        <div>
                            <h5>Mobile No</h5>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Phone Number" id="phone" name="phone">
                        </div>

                        <div>
                            <h5>Password</h5>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Password" id="password" name="password">
                        </div>

                        <div>
                            <h5>Confirm Pasword</h5>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirm Password" id="cpassword" name="cpassword">
                        </div><br>
                        <div class="form-group small">
                            <a href="#" class="forgot-link">Forgot Password?</a>
                        </div> <br>
                        <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                    </form>			
                    <div class="text-center small">Already have an account? <a href="{{route('userlogin')}}">Login Now</a></div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
@include('user.footer');