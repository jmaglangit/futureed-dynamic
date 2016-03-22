@extends('client.app')

@section('content')

	<div class="container dshbrd-con" ng-cloak>

		<div class="error-response col-md-6 col-md-offset-3">
		    <h1 class="error-display">503</h1>

		    <h2>
		    	<strong>{!! trans('messages.be_right_back') !!}</strong>
		    </h2>
		    <p class="error-text">
			    {!! trans('messages.on_maintenance') !!}
		    </p>
		</div>
	</div>
  
@stop

@section('scripts')

@stop