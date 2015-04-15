@extends('student.app')

@section('content')

<div class="container login">
  <div class="col-md-6 col-md-offset-3">
    <div class="form-style form-select-password">
      <form name="success_form" id="success_form" 
            action="{!! route('student.login.reset_password') !!}" method="POST">
        <div class="form_content">
          <div class="title">{!! $title !!}</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>

          <div ng-if="{!! $show !!}">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>
            <p class="text">
              <strong>Success!</strong>
              <br /> An email to reset your password has been sent to your email account. 
            </p>
            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a code that you need to input below.</small>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="reset_code" name="reset_code" placeholder="Reset Code" required />
              <input type="hidden" ng-model="email" name="email" value="{!! $email !!}" required />
              <input type="hidden" ng-model="user_id" name="user_id" required />
            </div>
            <button type="button" class="btn btn-red" ng-click="validateCode(reset_code)">PROCEED</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

  @section('footer')

  @overwrite

  @section('scripts')

  {!! Html::script('/js/student/login.js') !!}

  @stop