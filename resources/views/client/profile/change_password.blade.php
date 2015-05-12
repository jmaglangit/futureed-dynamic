@extends('client.app')
	@section('navbar')
		@include('client.partials.main-nav')
	@stop

	@section('content')
		<div class="container dshbrd-con" ng-cloak>
			<div class="wrapr">
				<div class="client-nav side-nav">
					@include('client.partials.dshbrd-side-nav')
				</div>
				<div class="client-content">
					<div class="content-title">
						<div class="title-main-content">
							Change Password
						</div>
					</div>
					<div class="form-content col-xs-12">
						<div class="alert alert-error" ng-if="errors">
				            <p ng-repeat="error in errors" > 
				              {! error !}
				            </p>
				        </div>
				        <div class="alert alert-success" ng-if="success">
		                	<p>Successfully update profile.</p>
		                </div>
		                {!! Form::open(array('id' => 'client_change_pass', 'class' => 'form-horizontal'))!!}
		                	<div class="form-group">
		                		<label class="col-xs-3 control-label">Current Password <span class="required">*</span></label>
		                		<div class="col-xs-5">
			                		{!! Form::password('current_pass'
			                			, array(
				                			'class' => 'form-control'
				                			, 'id' => 'current_pass'
				                			, 'placeholder' => 'Current Password'
				                			, 'ng-model' => 'current_pass'
				                			, 'ng-model-option' => "{debounce: {'default' : 10000}}")
				                		)!!}
				                </div>		
		                	</div>
		                	<div class="form-group">
		                		<label class="col-xs-3 control-label">New Password <span class="required">*</span></label>
		                		<div class="col-xs-5">
			                		{!! Form::password('new_pass'
			                			, array(
				                			'class' => 'form-control'
				                			, 'id' => 'new_pass'
				                			, 'placeholder' => 'New Password'
				                			, 'ng-model' => 'new_pass'
				                			, 'ng-model-option' => "{debounce: {'default' : 10000}}") 
				                		)!!}
				                </div>		
		                	</div>
		                	<div class="form-group">
		                		<label class="col-xs-3 control-label">Confirm Password <span class="required">*</span></label>
		                		<div class="col-xs-5">
			                		{!! Form::password('confirm_pass'
			                			, array(
				                			'class' => 'form-control'
				                			, 'id' => 'confirm_pass'
				                			, 'placeholder' => 'Confirm Password'
				                			, 'ng-model' => 'confirm_pass'
				                			, 'ng-model-option' => "{debounce: {'default' : 10000}}") 
				                		)!!}
				                </div>		
		                	</div>
		                	<div class="form-group">
							<div class="btncon-client col-xs-6 col-xs-offset-3">
								<a type="button" class="btn btn-gold">Save</a>
							</div>
						</div>
		                </form>
					</div>
				</div>
			</div>			
		</div>
	@stop

	@section('footer')

	@section('scripts')

	@stop