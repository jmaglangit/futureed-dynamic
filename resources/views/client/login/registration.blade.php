@extends('client.app')

@section('content')
<div class="container" ng-controller="LoginController as register" ng-cloak>
  <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
  
  <div class="form-style form-wide" ng-show="!registered"> 
    <div class="title">Register as</div>
    <div class="row">
      <div class="col-md-12 register_users">
        <div class="col-md-3 col-md-offset-3" ng-click="register.selectRole('user_principal')">
          {!! Html::image('images/user_principal.jpg', 'Principal'
            , array(
              'id' => 'user_principal'
              , 'ng-class' => '{role : !register.principal}'
            )
          ) !!}
          <h4>Principal</h4>
        </div>
        <div class="col-md-3" ng-click="register.selectRole('user_parent')">
          {!! Html::image('images/user_parent.jpg', 'Parent'
            , array(
              'id' => 'user_parent'
              , 'ng-class' => '{role : !register.parent}'
            )
          ) !!}
          <h4>Parent</h4>
        </div>
      </div>
      <div class="col-md-12" ng-if="register.role_click">
        <div class="alert alert-danger" style="text-align:left;" ng-if="errors">
          <p ng-repeat="error in errors"> 
            {! error !}
          </p>
        </div>

        <div template-directive template-url="{!! route('client.partials.registration_form') !!}"></div>
      </div>
    </div>
  </div>

  <div template-directive template-url="{!! route('client.partials.registration_success') !!}"></div>

  @include('student.login.terms-and-condition')
  @include('student.login.privacy-policy')

</div>
@endsection

@section('scripts')

  {!! Html::script('/js/client/controllers/login_controller.js') !!}
  {!! Html::script('/js/client/services/login_service.js') !!}
  {!! Html::script('/js/client/login.js') !!}

@stop