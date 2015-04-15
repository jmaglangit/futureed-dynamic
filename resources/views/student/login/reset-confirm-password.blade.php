@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <form id="reset_password_form" action="{!! route('student.login.reset-confirm-password') !!}" name="reset_password_form" method="POST">
        <div class="form-style form-select-password clearfix">
          <div class="title">Select a picture to confirm your new password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in {!! $image_pass !!}" ng-click="highlight($event)">
                 <img ng-src="{! item.password_image_file !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
              <div class="row">
                <div class="col-sm-6"><button type="button" ng-click="undoNewPassword()" class="btn btn-red">Previous</a></div>
                <div class="col-sm-6"><button type="button" class="btn btn-red" ng-click="validateNewPassword()">Reset</a></div>
              </div>
            </ul>
          </div>

          <input type="hidden" name="reset_code" id="reset_code" value="{!! $reset_code !!}" />
          <input type="hidden" name="id" id="id" value="{!! $id !!}" />
          <input type="hidden" name="selected_image_id" id="selected_image_id" value="{!! $selected_image_id !!}"/>
          <input type="hidden" name="image_pass" value="{!! $image_pass !!}" />
        </div>
      </form>
    </div>
  </div>
@stop

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop