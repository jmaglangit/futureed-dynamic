<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br>
<div>
    <div>Thanks for joining us at Future Lesson and congratulations on becoming part of the coolest community
        of learners on the web!  We look forward to taking this incredible learning adventure with you.</div>
    <br>
    <div>To start your learning we need you to confirm with the code on the link provided below. </div>
    <br>
    <div>Your confirmation code : {{ $code  }}</div>
    <br>
    <div>Link to Future Lessons: <a href="{{ $link }}">Code Confirmation</a></div>
</div>
</body>
</html>