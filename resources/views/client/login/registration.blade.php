@extends('client.app')

@section('content')
<div class="container" ng-controller="LoginController as register" ng-cloak>
  <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
  
  <div class="form-style form-wide" ng-show="!register.registered"> 
    <div class="title">Register as</div>
    <div class="row">
      <div class="col-md-12 register_users">
        <div class="col-md-3 col-md-offset-3" ng-click="register.selectRole('Principal')">
          {!! Html::image('/images/user_principal.png', 'Principal'
            , array(
              'id' => 'user_principal'
              , 'class' => 'client-reg-img'
              , 'ng-class' => '{role : !register.principal}'
            )
          ) !!}
          <h4>Principal</h4>
        </div>
        <div class="col-md-3" ng-click="register.selectRole('Parent')">
          {!! Html::image('/images/user_parent.png', 'Parent'
            , array(
              'id' => 'user_parent'
              , 'class' => 'client-reg-img'
              , 'ng-class' => '{role : !register.parent}'
            )
          ) !!}
          <h4>Parent</h4>
        </div>
      </div>
      <div class="col-md-12" ng-if="register.role_click">
        <div class="alert alert-error" ng-if="errors">
          <p ng-repeat="error in errors track by $index"> 
            {! error !}
          </p>
        </div>

        <div template-directive template-url="{!! route('client.partials.registration_form') !!}"></div>
      </div>
    </div>
  </div>

  <div template-directive template-url="{!! route('client.partials.registration_success') !!}"></div>

  @include('client.login.terms-and-conditions')
  @include('student.login.privacy-policy')

</div>
@endsection

@section('scripts')

  {!! Html::script('/js/client/controllers/login_controller.js') !!}
  {!! Html::script('/js/client/services/login_service.js') !!}
  {!! Html::script('/js/client/services/profile_service.js') !!}
  {!! Html::script('/js/client/login.js') !!}

@stop