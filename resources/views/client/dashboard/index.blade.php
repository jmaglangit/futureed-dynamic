@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con">
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')	
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span>Client Dashboard</span>
					</div>
				</div>

				<div class="form-content col-xs-12">

					<div template-directive template-url="{!! route('client.parent.dashboard.index') !!}"></div>

					<div template-directive template-url="{!! route('client.principal.dashboard.index') !!}"></div>

					<div template-directive template-url="{!! route('client.teacher.dashboard.index') !!}"></div>

				</div>
			</div>
		</div>
	</div>  
@stop

@section('scripts')

@stop