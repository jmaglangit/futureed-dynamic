@extends('student.app')

@section('content')

  <div ng-init="getImagePassword()"></div>
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password">
        <div class="title">Please Select Your Password</div>
        <div class="error" ng-if="error">
          <p>warning style 1</p>
        </div>

        <form name="passwordForm">
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in imagePass">
                 <!-- {!! Html::image('{! item.password_image_file !}', false) !!} -->
                 <img ng-src="{! item.password_image_file !}" alt="{! item.name !}">
              </li>
              <p><button type="button" class="btn btn-red" ng-click="validatePassword()">Submit</button></p>
            </ul>
          </div>
          <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        </form>
      </div>
    </div>
  </div>
  
@stop

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop