@extends('student.app')

@section('content')

  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password">
        <div class="title">Email Sent</div>
        <div class="error" style="display: none;">Reset code should not be empty.</div>
        <div class="form_content">
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          <p class="text">
            <strong>Success!</strong> An email to reset your password has been sent to your email account. 
          </p>
          <small>Please check your inbox or your spam folder for the email. Click on the password recovery link and follow the instructions on how to reset your password.</small>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop