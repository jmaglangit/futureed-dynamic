@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop
@section('content')
	<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr">
			<div class="side-nav">
				@include('student.partials.dshbrd-side-nav')
			</div>
			<div class="content">
				<div class="hdr">
					<div class="avtrcon">
						<img ng-src="{! user.avatar !}">
					</div>
					<div class="detcon">
						<h2>
						<span class="thin">Edit</span>
						Email
					</h2>
					</div>					
				</div>
				@include('student.profile.email_password_confirm')
				<div class="form-content col-md-12" ng-show="!email_pass">

					<div class="alert alert-danger" ng-if="error">
	                    <p>{! error !}</p>
	                </div>
	                <div class="alert alert-success" ng-if="success">
	                	<p>{! success_msg !}</p>
	                </div>
	                
					<form class="form-horizontal" name="edit_email" id="edit_email">
						<div class="form-group">
							<label for="current_email" class="col-xs-2 control-label">
								Current Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								{!! Form::text('email_current', ''
									, array(
										'class' => 'form-control'
										, 'placeholder' => 'Current Email'
										, 'ng-model' => 'email_current'
										, 'ng-model-option' => "{debounce: {'default' : 10000}}"
										, 'ng-blur' => "checkCurrentEmail(email_current)")
								)!!}
							</div>
							<div class="col-xs-5 alert-message">
	                            <i ng-if="c_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="c_success" class="fa fa-check success-color"></i>
	                            <span ng-if="c_error" class="alert alert-error edit-mail">{! c_error !}</span>
	                        </div>
						</div>
						<div class="form-group">
							<label for="new_email" class="col-xs-2 control-label">
								New Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								{!! Form::text('email_new', ''
									, array(
										'class' => 'form-control'
										, 'placeholder' => 'New Email'
										, 'ng-model' => 'email_new'
										, 'ng-model-option' => "{debounce: {'default' : 10000}}"
										, 'ng-blur' => "checkEmailChange(email_new, 'Student')")
								)!!}
							</div>
							<div class="col-xs-5 alert-message">
	                            <i ng-if="n_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="n_success" class="fa fa-check success-color"></i>
	                            <span ng-if="n_error" class="alert alert-error edit-mail"> {! n_error !}</span>
	                        </div>
						</div>						
						<div class="form-group">
							<label for="confirm_email" class="col-xs-2 control-label">
								Re-Enter Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								{!! Form::text('email_new', ''
									, array(
										'class' => 'form-control'
										, 'id' => 'email_confirm'
										, 'placeholder' => 'Confirm Email'
										, 'ng-model' => 'email_confirm'
										, 'ng-model-option' => "{debounce: {'default' : 10000}}"
										, 'ng-blur' => "checkEmailConfirm(email_confirm)")
								)!!}
							</div>
							<div class="col-xs-5 alert-message">
	                            <i ng-if="cf_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="cf_success" class="fa fa-check success-color"></i>
	                            <span ng-if="cf_error" class="alert alert-error edit-mail"> {! cf_error !}</span>
	                        </div>
						</div>
						<div class="form-group">
							<div class="btncon col-xs-9" style="float:right;">
								<a type="button" class="btn btn-gold" ng-click="saveEmail(email)">Save</a>
							</div>
						</div>						
					</form>
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop