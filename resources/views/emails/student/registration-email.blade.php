<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br/>
<div>
    <div>Thanks for joining us at Future Lesson and congratulations on becoming part of the coolest community of learners on the web!  We look forward to taking this incredible learning adventure with you.
</div>
	<br>
	<div>So tell us, who would you like to be when you grow up? A doctor, astronaut, scientist?  Pick your Avatar </div>
    <br>
    <div>Your confirmation code : {{ $code  }}</div>
    <br>
    <div>Link to Future Lessons: <a href="{{ $link }}">Confirm Code</a></div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>

</div>
</body>
</html>