<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br/>
<div>
    <div>Thanks for joining us at Future Lesson and congratulations on becoming part of the coolest community
	of learners on the web!  We look forward to taking this incredible learning adventure with you and your student.</div>
    <br>
    <div>To start your learning we need you to confirm by clicking the link provided below. </div>
    <br>
    <div><a href="{{ $link }}">Confirm Email</a></div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>
</div>
</body>
</html>