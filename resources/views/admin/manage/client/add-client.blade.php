@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span>Add New Client</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-error" ng-if="errors">
			            <p ng-repeat="error in profile.errors track by $index" > 
			              	{! error !}
			            </p>
			        </div>
	                <div class="alert alert-success" ng-if="success">
	                	<p>Successfully update profile.</p>
	                </div>
	                {!! Form::open(array('id'=> 'search_form', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
	                <fieldset>
	                	<legend class="legend-name-mid">
	                		Personal Information
	                	</legend>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="first_name">Firstname</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('first_name',''
	                				, array(
	                					'placeHolder' => 'Firstname'
	                					, 'ng-model' => 'first_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="last_name">Lastname</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('last_name',''
	                				, array(
	                					'placeHolder' => 'Lastname'
	                					, 'ng-model' => 'last_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="first_name">Role</label>
	                		<div class="col-xs-5">
	                			{!! Form::select('role', 
	                				[
		                				'Principal' => 'Principal', 
		                				'Teacher' => 'Teacher', 
		                				'Parent' => 'Parent'
		                			],
		                			null
	                				, 
	                				[	 
	                				'ng-model' => 'role', 
	                				'class' => 'form-control'
	                				]	
	                			) !!}
	                		</div>
	                	</div>
	                </fieldset>
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer')

@overwrite
	
@section('scripts')
@stop