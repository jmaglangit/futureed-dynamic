<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
	<div>{!! trans('messages.email_resendregistration_msg3') !!}: <a href="{{ $link }}">{!! trans('messages.confirm_code') !!}</a></div>
    <div>{!! trans('messages.code') !!} : {{ $code  }}</div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>
    
</div>
</body>
</html>