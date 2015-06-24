<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi there {{ $name }},</div><br/>

<div>
    <div>   {{ $school_name }} has assigned you to {{ $class_name }} to teach. You may now start adding your students to your class.
    </div>
    <br/>
    <div>   Click <a href="{{ $login_link }}">here</a> to login.
    </div>
    <br/>
    <div>Thanks,</div><br/>
    <div>Admin</div>

</div>
</body>
</html>