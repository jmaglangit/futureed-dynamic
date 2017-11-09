<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
    <div>{!! trans('messages.email_change_password_msg') !!} {{$new_password}}.</div>

    <br/><div>{!! trans('messages.email_change_password_msg2') !!}</div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>


</div>
</body>
</html>