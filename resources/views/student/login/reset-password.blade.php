@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-8 col-md-offset-2">
      <form id="reset_password_form" action="{!! route('student.login.reset-password-success') !!}" name="reset_password_form" method="POST">
        <div class="form-style form-select-password">
          <div ng-if="!password_selected" id="title" class="title">Select a picture for your new password</div>
          <div ng-if="password_selected" id="title" class="title">Select a picture to confirm your new password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline" ng-init="getImagePassword()">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
            <button type="button" ng-if="!password_selected" class="btn btn-red" ng-click="selectNewPassword()">Proceed</button>
            <div class="row" ng-if="password_selected">
              <div class="col-sm-6"><button type="button" ng-click="undoNewPassword()" class="btn btn-red">Previous</button></div>
              <div class="col-sm-6"><button type="button" class="btn btn-red" ng-click="validateNewPassword()">Save</button></div>
            </div>
          </div>
        </div>

        <input type="hidden" name="code" ng-model="code" id="code" value="{!! $code !!}" />
        <input type="hidden" name="id" ng-model="id" id="id" value="{!! $id !!}" />
      </form>
    </div>
  </div>
@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop