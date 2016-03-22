<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $student_name  }},</div><br/>

<div>
    <div>{{$teacher_name}} {!! trans('messages.email_invite_student_msg') !!} <a href="{{$link}}"> {!! trans('messages.email_invite_student_msg2') !!} </a> {!! trans('messages.email_invite_student_msg3') !!}</div>
    <br/>
    <div>{!! trans('messages.email_invite_student_msg4') !!}</div><br/>
    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>
</div>
</body>
</html>