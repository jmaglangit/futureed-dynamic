@extends('client.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-6 col-md-offset-1" ng-show="!sent">
      <div class="form-style form-narrow">
        <div class="title">Retrieve Password</div>
        <div class="error" ng-if="error">
          <p>
            {! error !}
          </p>
        </div>
        <form action="">
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="text" ng-model="username" />
          </div>
          <button type="button" class="btn btn-blue" ng-click="forgotPassword()" ng-disabled="disabled">
            <i ng-if="disabled" class="fa fa-spinner fa-spin"></i> SEND 
          </button>
          <a href="{!! route('client.login') !!}" class="btn btn-gold" ng-disabled="disabled">Cancel</a>
        </form>
      </div>
    </div>

    <div class="col-md-6 col-md-offset-1 form-style" ng-if="sent">
      <form name="success_form" id="success_form" 
            action="{!! route('client.login.reset_password') !!}" method="POST">
        <div class="form_content">
          <div class="title" ng-if="!resend && sent">Email Sent</div>
          <div class="title" ng-if="resend && sent">Code Resent</div>

          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>

          <div>
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>
            <div>
              <p class="text">
                <strong>Success!</strong>
                <br /> An email to reset your password has been sent to your email account.
              </p>
            </div>
            <br />
            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a code that you need to input below.</small>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="reset_code" name="reset_code" placeholder="Reset Code" autocomplete="off" />
              <input type="hidden" ng-model="id" name="id" required />
            </div>
            <button type="button" ng-disabled="disabled" class="btn btn-blue" ng-click="validateCode(reset_code)">PROCEED</button>
            <button type="button" ng-disabled="disabled" class="btn btn-gold" ng-click="resendCode()">
              <i ng-if="disabled" class="fa fa-spinner fa-spin"></i> Resend Code
            </button>
          </div>
        </form>
      </div>


  </div>
@endsection