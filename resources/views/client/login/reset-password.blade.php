@extends('client.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-1" ng-show="!success">
      <div class="form-style form-narrow">
        <div class="title">Reset Password</div>
          <div class="error" ng-if="error">
            <p>
              {! error !}
            </p>
          </div>
          <form>
          <div class="input">
            <div class="icon">
              <i class="fa fa-unlock-alt"></i>
            </div>
            <input placeholder="New Password" type="password" ng-model="new_password" />
          </div>
          <div class="input">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            <input placeholder="Confirm New Password" type="password" ng-model="confirm_password" />
          </div>
          <button type="button" class="btn btn-blue" ng-click="resetClientPassword()">Reset</button>
        </form>
      </div>
    </div>

    <div class="col-md-6 col-md-offset-1" ng-if="success">
      <div class="form-style form-select-password">
        <div class="title">Success!</div>
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
           Your password has been set. <br /> You may now use your new password to login. <br />
          <a class="btn btn-blue" href="{!! route('client.login') !!}">Click here to Login</a>    
      </div>
    </div>
  </div>
@endsection