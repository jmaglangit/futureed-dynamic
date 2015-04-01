@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password clearfix">
        <div class="title">Success! You're password has been reset.</div>
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          <strong>Success!</strong> You're password has been reset. You may now use your new password to login.
          <a class="btn btn-red">Click here to Login</a>    
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop