<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name }},</div><br/>

<div>
    <div>{{ $school_name }} {!! trans('messages.email_invite_teacher_to_teach_msg') !!} {{ $class_name }} {!! trans('messages.email_invite_teacher_to_teach_msg2') !!}
    </div>
    <br/>
    <div>{!! trans('messages.click') !!} <a href="{{ $login_link }}">{!! trans('messages.here') !!}</a> {!! trans('messages.email_to_login') !!}
    </div>
    <br/>
    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

</div>
</body>
</html>