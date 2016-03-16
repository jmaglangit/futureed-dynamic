<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br/>
<div>
	<div>You have opt to resend your confirmation.</div>
    <br>
    <div><a href="{{ $link }}">Confirm Email</a></div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>

</div>
</body>
</html>