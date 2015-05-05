@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-8 col-md-offset-2" ng-show="!success">
      {!! Form::open(array('id' => 'reset_password_form'))!!}
        <div class="form-style form-select-password">
          <div  id="title" class="title">
            <p ng-if="!password_selected">Select a picture for your new password</p>
            <p ng-if="password_selected">Select a picture to confirm your new password</p>
          </div>
          
          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline" ng-init="getImagePassword()">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
            <button type="button" ng-if="!password_selected" class="btn btn-red btn-medium" ng-click="selectNewPassword()">Proceed</button>
            <div ng-if="password_selected">
                <div class="btn-container">
                    <a type="button" class="btn btn-purple btn-medium" ng-click="undoNewPassword()">Previous</a>
                    <a type="button" class="btn btn-red btn-medium" ng-click="saveNewPassword()">Save</a>
                </div>  
            </div>
          </div>
        </div>

        {!! Form::hidden('code', $code, array('ng-model' => 'code')) !!}
        {!! Form::hidden('id', $id, array('ng-model' => 'id')) !!}
      {!! Form::close() !!}
    </div>

    <div class="col-md-6 col-md-offset-3" ng-if="success">
      <div class="form-style form-select-password">
        <div class="title">Success!</div>
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
           Your password has been set. <br /> 
           You may now use your new password to login. <br />
           <br />
          <a class="btn btn-red" href="{!! route('student.login') !!}">Click here to Login</a> 
      </div>
    </div>
  </div>
@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop