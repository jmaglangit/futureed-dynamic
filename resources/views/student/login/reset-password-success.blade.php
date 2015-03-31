@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password clearfix" style="min-height:450px;">
        <div class="title">Success! You're password has been reset. </div>
        <div class="error" style="display: none;">
          <p>warning style 1</p>
        </div>
        <div class="">
          <div style="width:120px; margin:30px auto 30px;">
          <i class="fa fa-check fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
          </div>
            <strong>Success!</strong> You're password has been reset. You may now use your new password to login.
            <div>
              <a class="btn btn-red">Click here to Login</a>
            </div>
        </div>        
      </div>
    </div>
  </div>
@endsection