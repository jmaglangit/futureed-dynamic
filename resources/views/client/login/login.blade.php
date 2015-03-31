@extends('client.app')

@section('content')
<style>
body {background: url("/images/bcg_triangle.svg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-4 col-md-offset-1" style="margin-top:80px;">
      <div class="form-style form-narrow">
      	<!-- ERROR -->
      	<div style="display:none;">
	      	<div class="title">Account Locked</div>
	        <div class="form_content">
	          <div style="width:120px; margin:0 auto 30px;">
	          <i class="fa fa-lock fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
	          </div>
	
	          <p>Your account has been locked due to maximum attempt of invalid login.</p>
	          <p>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</p>
	        </div>
      	</div>
		<!--// ERROR -->
        <div class="title">Login to your account</div>
        {!! Form::open() !!}
          <!-- <span>Email or Username</span> -->
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::email('login', null, ['placeholder' => 'Email or Username']) !!}
          </div>
          <!-- <span>Password</span> -->
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('password', null, ['placeholder' => 'Password']) !!}
          </div>
          <div class="submit">LOGIN</div>
        </form>
        {!! link_to_route('client.login.forgot_password', 'Forgot your password?', array(), ['class' => 'login_bcg']) !!}
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