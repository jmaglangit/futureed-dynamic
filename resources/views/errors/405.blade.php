@extends('client.app')

@section('content')

	<div class="container dshbrd-con" ng-cloak>

		<div class="error-response col-md-6 col-md-offset-3">
		    <h1 class="error-display">405</h1>

		    <h2>
		    	<strong>{!! trans('messages.invalid_access') !!}</strong>
		    </h2>
		    <p class="error-text">
			    {!! trans('messages.sorry_no_access') !!}
		    </p>
		    
		    
		    <div class="btn-container">
		    	<a class="btn btn-light-blue btn-medium" href="{!! route('student.login') !!}">
			        <i class="fa fa-home"></i>
			        {!! trans('messages.take_me_home') !!}
			    </a>
			    <!-- <a href="#" class="btn btn-light-blue btn-medium disabled">
			        <i class="fa fa-envelope-o"></i>
			        Contact Support
			    </a> -->
			</div>
		</div>
	</div>
  
@stop

@section('scripts')

@stop