@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <form id="reset_password_form" action="{!! route('student.login.reset-confirm-password') !!}" name="reset_password_form" method="POST">
        <div class="form-style form-select-password"  ng-init="getImagePassword()">
          <div class="title">Select a picture for your new password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in imagePass" ng-click="highlight($event)">
                 <img ng-src="{! item.password_image_file !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
              <p><button type="button" class="btn btn-red" ng-click="storeNewPassword()">Save and Proceed</button></p>
            </ul>
            <input type="hidden" id="response" name="response" >
          </div>

          <input type="hidden" name="reset_code" id="reset_code" value="{!! $code !!}" />
          <input type="hidden" name="student_id" id="student_id" value="{!! $id !!}" />
          <input type="hidden" name="selected_image_id" id="selected_image_id" />
        </div>
      </form>
    </div>
  </div>
@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop