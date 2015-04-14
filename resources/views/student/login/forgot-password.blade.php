@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style">
        <div class="title">Retrieve Password</div>
        <form action="" name="forgotPassForm">
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="text" ng-model="username" id="" required>
          </div>
          <div class="submit" ng-click="forgotPassword(username)">SEND</div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop