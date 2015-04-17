@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password clearfix">
        <div class="title">Success!</div>
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
           You're password has been set. <br /> You may now use your new password to login. <br />
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