@extends('app')

@section('content')
<style>
body {background: url("images/bcg_bookapple.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-4 col-md-offset-1" style="margin-top:80px;">
      <div class="form-style form-narrow">
        <div class="title">Reset Password</div>
        <form action="">
          <!-- <span>Password</span> -->
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            <input placeholder="New Password" type="password" name="" id="">
          </div>
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            <input placeholder="Confirm New Password" type="password" name="" id="">
          </div>
          <div class="submit">RESET</div>
        </form>
        <!-- <a class="login_bcg" href="forgot-password.shtml">Forgot your password?</a> -->
        
      </div>
    </div>
  </div>
@endsection