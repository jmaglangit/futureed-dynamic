<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi') !!} {{$name}},</div><br/>

<div>
    <div>{{$parent_name}} {!! trans('messages.email_parent_added_student_msg') !!}</div>
    <br/>
    <div>{!! trans('messages.email_parent_added_student_msg2') !!}</div>
    <div>{!! trans('messages.email_parent_added_student_msg3') !!}: {{ $code }}</div>
    <br/>
    <div>{!! trans('messages.regards') !!},</div>
    <div>{!! trans('messages.admin') !!}</div>
</div>
</body>
</html>
