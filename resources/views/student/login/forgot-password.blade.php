@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style">
        <div class="title">Retrieve Password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>
        <form id="redirect_form" action="{!! route('student.login.forgot_password_success') !!}" method="POST">
          <input id="response" name="response" type="hidden" />
        </form>

        <form action="" name="forgot_pass_form" id="forgot_pass_form">
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="text" ng-model="username" name="username" required>
          </div>
          <div class="submit" ng-click="forgotPassword(username)">SEND</div>
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