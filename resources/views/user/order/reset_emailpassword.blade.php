<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resest Password Email</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <p>Hello Dear {{ $formData['user']->name }}</p>
    <h1>You Have Requested To Change Password</h1>

    <p>Please click the link given below to resest your password</p>

    <a href="{{ route('user.resestForgetPassword', $formData['token']) }}">Click Here</a>

    <p>
        Thanks.
    </p>
</body>

</html>
