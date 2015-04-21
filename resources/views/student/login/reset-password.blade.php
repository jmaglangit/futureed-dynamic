@extends('student.app')

@section('content')
  <div class="container login" ng-init="getImagePassword()" ng-cloak>
    @include('student.login.reset-confirm-password')

    <div class="col-md-8 col-md-offset-2" ng-if="!password_selected">
      <form id="reset_password_form" action="{!! route('student.login.reset-password-success') !!}" name="reset_password_form" method="POST">
        <div class="form-style form-select-password">
          <div id="title" class="title">Select a picture for your new password</div>
          <div class="error" ng-if="error">
            <p>{! error !}</p>
          </div>
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
            <button type="button" class="btn btn-red" ng-click="selectNewPassword()">Proceed</button>
          </div>

          <input type="hidden" name="code" id="code" value="{!! $code !!}" />
          <input type="hidden" name="id" id="id" value="{!! $id !!}" />
          <input type="hidden" name="selected_image_id" id="selected_image_id" />
          <input type="hidden" name="image_pass" />
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