<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div>
<br/>
<div>
    <div>You have been added in {{$class_name}} by Teacher {{$teacher_name}}.
</div>
	<div>Your confirmation code : {{ $code  }}. This code will be used by your parent if they want to add you in their dashboard.</div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>

</div>
</body>
</html>