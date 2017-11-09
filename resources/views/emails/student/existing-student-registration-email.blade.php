<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name }},</div>
<br/>
<div>
    <div>{!! trans('messages.email_existing_student_registration_msg') !!} {{$class_name}} {!! trans('messages.email_existing_student_registration_msg2') !!} {{$teacher_name}}.
</div>
	<div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

</div>
</body>
</html>