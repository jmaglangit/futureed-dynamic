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
			</div>
		</div>
	</div>  
@stop

@section('scripts')

@stop