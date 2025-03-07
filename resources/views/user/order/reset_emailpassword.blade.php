{{-- <!DOCTYPE html>
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

</html> --}}




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <p>Hello {{ $formData['user']->name }},</p>
    <h3>You Have Requested To Reset Your Password</h3>

    <p>Click the button below to reset your password:</p>

    <a href="http://127.0.0.1:8001/reset-forget-password/{{ $formData['token'] }}"
       style="display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
       Reset Password
    </a>

    <p>If you did not request this, please ignore this email.</p>

    <p>Thanks,</p>
    <p>Your App Team</p>
</body>
</html>
