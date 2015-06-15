<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi  {{$name}},</div><br/>

<div>
    <div>{{$parent_name}} has requested to add you in his/her dashboard.</div>
    <br/>
    <div> Please give this invitation code so that you will be added in his/her student list.</div>
    <div>Invitation code : {{ $code }}</div>
    <br/>
    <div>Regards,</div>
    <div> Admin</div>
</div>
</body>
</html>
