<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Hi there {{ $student_name  }}</h2>

<div>
    <div>{{$teacher_name}} would like you to join us on the Future Lesson platform.  Please go to <a href="{{$link}}"> Registration Page </a> and create your profile to join this community.</div>
    <br/>
    <div>Your confirmation code : {{ $code }}. This code will be used by your parent if they want to add you in their dashboard.</div>
    <br/>
    <div>We look forward to taking this incredible learning adventure with you and your students.</div>
</div>
</body>
</html>