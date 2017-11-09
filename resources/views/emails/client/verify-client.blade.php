<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
	<div>{!! trans('messages.email_verify_client_msg') !!} <br/><br/>{!! trans('messages.email_verify_client_msg2') !!} <a href = "{{$link}}">{!! trans('messages.email_verify_client_msg3') !!}</a> {!! trans('messages.email_verify_client_msg4') !!}
</div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>
    
</div>
</body>
</html>