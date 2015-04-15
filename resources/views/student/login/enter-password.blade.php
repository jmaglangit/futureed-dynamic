@extends('student.app')

@section('content')

  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password">
        <div ng-if="locked">
          <div class="title">Account Locked</div>
          <div class="form_content">
            <div style="width:120px; margin:0 auto 30px;">
            <i class="fa fa-lock fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
            </div>
  
            <p class="h4 text">Your account has been locked due to maximum attempt of invalid login.</p>
            <small>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</small>
            <p style="padding-bottom: 40px;">
              <a href="" class="btn btn-red">Reset Password</a>
            </p>
          </div>
        </div>

        <div ng-if="!locked" ng-init="getImagePassword()">
          <div class="title">Please Select Your Password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>

          <form id="password_form" action="{!! route('student.login.process') !!}" name="passwordForm" method="POST">
            <div class="form_content">
              <ul class="form_password list-unstyled list-inline">
                <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                   <img ng-src="{! item.password_image_file !}" alt="{! item.name !}">
                   <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
                </li>
                <p><button type="button" class="btn btn-red" ng-click="validatePassword()">Submit</button></p>
              </ul>
            </div>
            <input type="hidden" id="response" name="response" >
          </form>
        </div>
        <input type="hidden" name="id" id="student_id" value="{!! $id !!}">
      </div>
    </div>
  </div>
@stop

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop