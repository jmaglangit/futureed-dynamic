<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Hi there {{$name}}</h2>

<div>
    <div>Parent: {{$parent_name}}</div>
    <br/>
    <div>has requested to add you in his/her dashboard.</div>
    <br/>
    <div> Please give this invitation code so that you will be added in his/her student list.</div>
    <div>Invitation code : {{ $code }}</div>
    <br/>
    <div>Regards, Admin</div>
</div>
</body>
</html>
