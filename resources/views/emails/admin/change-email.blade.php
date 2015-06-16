<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>Hi {{ $name  }},</div><br/>

<div>
    <div>Your email has been changed from {{$email}} to {{$new_email}} You can now use this email in your <a href="{{ $link }}">login </a>.</div>

        <div>If you did not ask for this change, please contact the administrator right away.</div><br/>

    <div>Regards,</div><br/>
    <div>Admin</div>



</div>
</body>
</html>