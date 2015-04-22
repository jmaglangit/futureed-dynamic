@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
      <div class="form-style">

        <div ng-show="!locked && !enter_pass">
          <form id="login_form" name="loginForm" method="POST">
            <div class="title">Internal Server Error</div>
            <div class="error">
              <p>Please contact your administrator.</p>
            </div>
          </form>
          <div class="text-group">
            <p><a href="{!! route('student.login') !!}" class="btn btn-purple">Take Me Home</a></p>      
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('footer')
