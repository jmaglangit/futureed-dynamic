<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name }},</div>
<br/>
<div>
    <div>{!! trans('messages.email_registration_teacher_email_msg') !!}</div>
    <br>
    <div>{!! trans('messages.email_registration_teacher_email_msg2') !!}</div>
    <br>
   <div><a href="{{ $link }}">{!! trans('messages.confirm_email') !!}</a></div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

</div>
</body>
</html>