<div ng-if="login.active_confirm">
	<div class="form-style register_student form-wide" ng-cloak> 
		{!! Form::open(array('id' => 'registration_form' , 'class' => 'form-horizontal simple-form')) !!}

			<div class="form-header">
				<fieldset>
					<div class="form-group media">
						<div class="col-xs-9"> 
							<div class="media-left">
								{!! Html::image('/images/user_student.png') !!}
							</div>
							<div class="media-body">
								<h3 class="box-title">Register {! login.record.media_type !} Detail</h3>
								<div class="info-box rd">
									<h4>For Students 13 years old and below</h4>
									<p>Parents should be the one to register, please click {!! Html::link(route('client.registration'), 'here') !!} to register.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-3"></div>
					</div>
				</fieldset>
			</div>
			
			<div class="form-content col-xs-12">
				<div class="col-xs-12 success-container" ng-if="login.errors || login.success">
					<div class="alert alert-error" ng-if="login.errors">
						<p ng-repeat="error in login.errors track by $index" > 
							{! error !}
						</p>
					</div>
					<div class="alert alert-success" ng-if="login.success">
						<p ng-repeat="success in login.success track by $index" > 
							{! success !}
						</p>
					</div>
				</div>

				<div>(<span class="required">*</span> ) Indicates a required field.</div>
				<fieldset>
					<legend>Personal Information</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">Birthday<span class="required">*</span></label>
						<div class="col-xs-4">
							<input type="hidden" id="birth_date" 
								onchange="checkAge()"
								ng-init="login.setDropdown(login.record.birth_date)">
						</div>
						<label class="col-xs-2 control-label">Gender<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::select('gender'
								, array(
									'' => '-- Select Gender --'
									, 'Male' => 'Male'
									, 'Female' => 'Female'
								)
								, ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['gender'] }"
									, 'ng-model' => 'login.record.gender')
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2 control-label">First Name<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('first_name', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
									, 'placeholder' => 'First Name' 
									, 'ng-model' => 'login.record.first_name'
								)
							) !!}
						</div>
						<label class="col-xs-2 control-label">Last Name<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('last_name', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
									, 'placeholder' => 'Last Name' 
									, 'ng-model' => 'login.record.last_name')
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2 control-label">City</label>
						<div class="col-xs-4">
							{!! Form::text('city', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['city'] }"
									, 'placeholder' => 'City' 
									, 'ng-model' => 'login.record.city')
							) !!}
						</div>
						<label class="col-xs-2 control-label">State</label>
						<div class="col-xs-4">
							{!! Form::text('state', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['state'] }"
									, 'placeholder' => 'State' 
									, 'ng-model' => 'login.record.state'
								)
							) !!}
						</div>
					</div>
					<div class="form-group" ng-init="getCountries()">
						<label class="col-xs-2 control-label">Country</label>
						<div class="col-xs-4">
							<select name="country_id" id="country" class="form-control" 
								ng-class="{ 'required-field' : login.fields['country_id'] }"
								ng-model="login.record.country_id" 
								ng-change="getGradeLevel(login.record.country_id)">
								<option value="">-- Select Country --</option>
								<option ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>User Credentials</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">Username <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('username', ''
								, array(
									'class' => 'form-control'
									, 'autocomplete' => 'off'
									, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
									, 'placeholder' => 'Username'
									, 'ng-model' => 'login.record.username'
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
									, 'ng-change' => "login.checkUsername(login.record.username, futureed.STUDENT, futureed.FALSE)"
								)
							) !!}
							
							<div> 
								<span ng-if="login.validation.u_error" class="error-msg-con">{! login.validation.u_error !}</span>
								<i ng-if="login.validation.u_loading" class="fa fa-spinner fa-spin"></i>
								<span ng-if="login.validation.u_success" class="error-msg-con success-color">{! futureed.MSG_U_AVAILABLE !}</span>
							</div>
						</div>

						<label class="col-xs-2 control-label">{! login.record.media_type !} E-mail<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('email', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['email'] }"
									, 'placeholder' => 'Email Address' 
									, 'ng-model' => 'login.record.email'
									, 'ng-disabled' => 'true'
								)
							) !!}
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>School Information</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">School level</label>
						<div class="col-xs-4">
							<select name="grade_code" ng-disabled="!grades.length" 
								class="form-control"
								ng-class="{ 'required-field' : login.fields['grade_code'] }"
								ng-model="login.record.grade_code">
								<option value="">-- Select Level --</option>
								<option ng-selected="login.record.grade_code == grade.code" ng-repeat="grade in grades"  ng-value="grade.code">{! grade.name !}</option>
							</select>
						</div><br><br>
					</div>    
				</fieldset> 
			</div>
			<div class="block_bottom">
				<fieldset>
					<div class="form-group">
						<div class="checkbox text-center">
							<label>
								{!! Form::checkbox('terms', 1, null, array('ng-model' => 'login.record.terms')) !!}
								
								I agree on the 

								{!! Html::link('#', 'Terms and Conditions'
									, array(
										'ng-click' => "showModal('terms_modal')"
										, 'data-toggle' => 'modal'
									)
								) !!}

								 and 

								{!! Html::link('#', 'Data Privacy Policy'
									, array(
										'ng-click' => "showModal('policy_modal')"
										, 'data-toggle' => 'modal'
									)
								) !!}
							</label>
						</div>
					</div>
					<div class="btn-container col-sm-6 col-sm-offset-3">
						{!! Form::button('Confirm'
							, array(
								'class' => 'btn btn-maroon btn-medium'
								, 'ng-click' => "login.confirmMediaDetails()"
							)
						) !!}

						{!! Html::link(route('student.login'), 'Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
							)
						)!!}
					</div>
				</fieldset>
			</div>
		{!! Form::close() !!}
	</div>	

	<div id="invalid_student" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header">
					
				</div>
				<div class="modal-body">
					<h5>Students 13 years old or younger cannot register. Please ask a Parent to sign up in the <a href="{!! route('client.registration') !!}">client site</a></h5>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'data-dismiss' => 'modal'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('student.login.terms-and-condition')
    @include('student.login.privacy-policy')
</div>

<div ng-if="login.active_confirm_success">
	<div class="login-container form-style">
		<div class="logo-container">
			{!! Html::image('/images/logo-md.png') !!}
		</div>

		<div class="title title-student">Registration Success</div>

		<div class="alert alert-success">
			<p> You have successfully registered.</p>
		</div>

		<div class="form-group">
			{!! Form::button('Proceed to Dashboard' 
			, array(
				  'class' => 'btn btn-maroon btn-medium'
				, 'ng-click' => 'login.proceedToDashboard()'
				)
			) !!}
		</div>
	</div>
</div>
