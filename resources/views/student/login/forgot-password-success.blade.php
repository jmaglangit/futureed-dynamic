@extends('student.app')

@section('content')
<style>
body {background: url("/images/bg-option-1.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:80px;">
      <div class="form-style form-select-password" style="padding-bottom: 70px;">
        <div class="title">Email Sent</div>
        <div class="form_content">
          <div style="width:120px; margin:0 auto 30px;">
          <i class="fa fa-check fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
          </div>
          <p class="text">
            <strong>Success!</strong> An email to reset your password has been sent to your email account. 
          </p>

          <small>Please check your inbox or your spam folder for the email. Click on the password recovery link and follow the instructions on how to reset your password.</small>
        </div>
      </div>
    </div>
  </div>
@endsection