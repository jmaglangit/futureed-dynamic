<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br/>
<div>
    <div>You have opt to resend your confirmation code.</div>
    <br>
    <div>Your confirmation code : {{ $code  }}</div>
    <br>
    <div>Link to Future Lessons: <a href="{{ $link }}">Confirm Code</a></div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>
</div>
</body>
</html>