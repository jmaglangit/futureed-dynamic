<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
    <div>{{$current_user}} {!! trans('messages.email_invite_student_msg') !!} <a href="{{$link}}">{!! trans('messages.email_invite_student_msg2') !!}</a> {!! trans('messages.email_invite_teacher_msg') !!}
    </div>
    <br/>
    <div>{!! trans('messages.email_invite_student_msg4') !!}
    </div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

</div>
</body>
</html>