@extends('app')

@section('content')
<style>
body {background: url("images/bcg_bookapple.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-4 col-md-offset-1" style="margin-top:80px;">
      <div class="form-style form-narrow">
        <div class="title">Forgot Password</div>
        <div class="form_content">
          <strong>Success!</strong> An email to reset your password has been sent to your email account. Please check your inbox or your spam folder for the email. Click on the password recovery link and follow the instructions on how to reset your password.
        </div>
      </div>
    </div>
  </div>
@endsection