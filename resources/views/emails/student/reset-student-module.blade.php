
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
    <div>{!! trans('messages.email_reset_student_module_msg') !!} {{$module}} {!! trans('messages.email_reset_student_module_msg2') !!}</div>
    <br/>
    <div>{!! trans('messages.email_reset_student_module_msg3') !!}</div><br/>
    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>
</div>
</body>
</html>