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
				<div class="form-content col-md-12">
					<div class="alert alert-danger" ng-if="error">
	                    <p>{! error !}</p>
	                </div>
	                <div class="alert alert-success" ng-if="success">
	                	<p>{! success_msg !}</p>
	                </div>
	                @include('student.login.enter-password')
					<form class="form-horizontal" name="edit_email" id="edit_email">
						<div class="form-group">
							<label for="current_email" class="col-xs-2 control-label">
								Current Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								<input type="text" class="form-control" id="current_email" name="current_email" placeholder="Current Email" ng-model="email_current" required />
							</div>
						</div>
						<div class="form-group">
							<label for="new_email" class="col-xs-2 control-label">
								New Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								<input type="text" class="form-control" id="new_email" name="new_email" placeholder="New Email" ng-model="email_new" ng-blur="checkEmailAvailability(email_new, 'Student')" required />
							</div>
							<div class="col-xs-5 alert-message">
	                            <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="e_success" class="fa fa-check success-color"></i>
	                            <span ng-if="e_error" class="alert alert-error"> Email Address is invalid or already exist</span>
	                        </div>
						</div>						
						<div class="form-group">
							<label for="confirm_email" class="col-xs-2 control-label">
								Re-Enter Email 
								<span class="required">*</span>
							</label>
							<div class="col-xs-5">
								<input type="text" class="form-control" id="confirm_email" name="confirm_email" placeholder="Re-enter Email" ng-model="email_confirm" required />
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