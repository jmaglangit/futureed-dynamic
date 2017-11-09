<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>{!! trans('messages.hi_there') !!} {{ $name  }},</div><br/>

<div>
	<div>{!! trans('messages.email_reject_client_msg') !!}
</div><br/><br/>
<div><a href = "{{$link}}">{!! trans('messages.email_reject_client_msg2') !!}</a></div><br/>

    <div>{!! trans('messages.regards') !!},</div><br/>
    <div>{!! trans('messages.admin') !!}</div>

    
</div>
</body>
</html>