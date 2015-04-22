@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style">
        <div class="title">Retrieve Password</div>
        <div class="error" ng-if="error">
          <p>{! error !}</p>
        </div>

        <form action="{!! route('student.login.forgot_password_success') !!}" 
              name="forgot_pass_form" id="forgot_pass_form" method="POST">
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="text" ng-model="username" name="username" autocomplete="off" />
            <input type="hidden" name="email"/>
          </div>
          <button type="button" class="btn btn-red" ng-click="forgotPassword()" ng-disabled="disabled">SEND</button>
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