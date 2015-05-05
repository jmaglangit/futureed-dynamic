@extends('client.app')

@section('content')

<div class="error-response col-md-6 col-md-offset-3">
    <h1 class="error-display">404</h1>

    <h2>
    	<strong>Page Not Found</strong>
    </h2>
    <p class="error-text">
	    Sorry, the page you are trying to access does not exist.
    </p>
    
    
    <div class="btn-container">
    	<a class="btn btn-light-blue btn-medium" href="{!! route('client.login') !!}">
	        <i class="fa fa-home"></i>
	        Take me home
	    </a>
	    <a href="#" class="btn btn-light-blue btn-medium">
	        <i class="fa fa-envelope-o"></i>
	        Contact Support
	    </a>
	</div>
</div>
  
@stop

@section('footer')

@overwrite

@section('scripts')

@stop