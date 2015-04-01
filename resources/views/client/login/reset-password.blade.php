@extends('client.app')

@section('content')
  <div class="container login">
    <div class="col-md-4 col-md-offset-1">
      <div class="form-style form-narrow">
        <div class="title">Reset Password</div>
        {!! Form::open() !!}
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