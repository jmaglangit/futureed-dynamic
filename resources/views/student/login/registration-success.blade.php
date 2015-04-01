@extends('student.app')

@section('content')

	<div class="container login">
    	<div class="col-md-6 col-md-offset-3">
	    	<div class="form-style form-select-password">
				<div class="title">Thank you for registering to Future Lesson!</div>
				<div class="error" style="display: none;">Reset code should not be empty.</div>
				<div class="form_content">
	        		<div class="roundcon">
		        		<i class="fa fa-check fa-5x img-rounded text-center"></i>
		        	</div>
		        	<p class="text">
		        		An email to reset your picture password has been sent to your email account.
		        	</p>
		        	<small>Please check your inbox or your spam folder for the email. The email contains a code that you need to input below.</small>
			        <form action="">
			          <div class="form-group">
			            <label for="forgot-password-success">Enter Code:</label>
			            <input type="text" name="forgot-password-success" class="form-control" id="">
			          </div>
			          <div class="form-group">
			            <a href="#" class="btn btn-red" id="">Confirm</a>
			          </div> 
			        </form>
			    </div>
		    </div>
	    </div>
	</div>

@stop

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop