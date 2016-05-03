<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
    <div>{!! trans('messages.email_change_email_msg') !!} {{$email}} {!! trans('messages.to') !!} {{$new_email}} {!! trans('messages.email_change_email_msg2') !!} <a href="{{ $link }}">{!! trans('messages.login') !!}</a>.</div>

        <div>{!! trans('messages.email_change_password_msg2') !!}</div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

</div>
</body>
</html>