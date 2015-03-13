@extends('app')

@section('content')
<style>
body {background: url("images/bcg_bookapple.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-4 col-md-offset-1" style="margin-top:80px;">
      <div class="form-style form-narrow">
        <div class="title">Login to your account</div>
        <form action="">
          <!-- <span>Email or Username</span> -->
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="email" name="" id="">
          </div>
          <!-- <span>Password</span> -->
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            <input placeholder="Password" type="password" name="" id="">
          </div>
          <div class="submit">LOGIN</div>
        </form>
        <a class="login_bcg" href="forgot-password.shtml">Forgot your password?</a>
        <div class="fb">
          SIGN UP
        </div>
      </div>
    </div>
    <div style="margin-top:170px; background:rgba(255,255,255,0.8); border-radius:5px; padding:20px; color:#000; font:normal 14px/20px Arial;" class="col-md-4">
      <b>HEADS UP:</b><br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc luctus libero ac enim faucibus pellentesque. Mauris eleifend tincidunt luctus. Suspendisse at nulla condimentum, rutrum leo at, molestie est. Sed leo arcu, posuere sed diam ac, pretium efficitur sem. Donec mattis eros metus, nec ultricies sapien interdum.
    </div>
  </div>
@endsection