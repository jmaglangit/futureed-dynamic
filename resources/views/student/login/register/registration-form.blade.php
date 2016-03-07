<div ng-if="login.active_registration">
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
								<h3 class="box-title">Student Registration</h3>
								<div class="info-box rd" >
									<h4>For Students 13 years old and below</h4>
									<p>Parents should be the one to register, please click {!! Html::link(route('client.registration'), 'here') !!} to register.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-3" ng-if="!login.record.invited">
							<div class="form-group col-xs-12">
								<button type="button" class="btn btn-fb"
									ng-click="login.loginViaFacebook()">
										<i class="fa fa-facebook"></i> Sign up via Facebook
								</button>
							</div>

							<div class="form-group col-xs-12 login-divider">
								<em>or</em>
							</div>

							<div class="form-group col-xs-12">
								<button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()"> 
									<span><img src="/images/icons/google-logo.png" /></span>
									<span>Sign up with Google</span> 
								</button>
							</div>
						</div>
					</div>
				</fieldset>
			</div>

			<div class="form-content col-xs-12" ng-if="login.record.invited && !login.record.id">
				<div class="alert alert-danger" ng-if="login.errors">
				  	<p ng-repeat="error in login.errors" > 
						{! error !}
					</p>
				</div>

				<div class="btn-container">
					{!! Html::link(route('student.registration'), 'Register New Account'
						, array(
							'class' => 'btn btn-maroon btn-medium'
						)
					)!!}
				</div>
			</div>
			
			<div ng-if="!login.record.invited || (login.record.invited && login.record.id)"> 
				<div class="form-content col-xs-12">
					<div class="alert alert-danger" ng-if="login.errors">
					  <p ng-repeat="error in login.errors" > 
						{! error !}
					  </p>
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
										, 'Female' => 'Female')
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
										, 'autocomplete' => 'off'
										, 'ng-model' => 'login.record.first_name')
								) !!}
							</div>
							<label class="col-xs-2 control-label">Last Name<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('last_name', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
										, 'placeholder' => 'Last Name' 
										, 'autocomplete' => 'off'
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
										, 'ng-model' => 'login.record.state')
								) !!}
							</div>
						</div>
						<div class="form-group" ng-init="getCountries()">
							<label class="col-xs-2 control-label">Country</label>
							<div class="col-xs-4">
								<select name="country_id" id="country" 
									class="form-control" 
									ng-class="{ 'required-field' : login.fields['country_id'] }"
									ng-model="login.record.country_id" 
									ng-change="getGradeLevel(login.record.country_id)"
									ng-init="login.record.country_id = futureed.UNITED_STATES">
									<option ng-selected ="login.record.country_id == futureed.FALSE" value="">-- Select Country --</option>
									<option ng-selected ="login.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>User Credentials</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Username</label>
							<div class="col-xs-4">
								{!! Form::text('username', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
										, 'placeholder' => 'Username' 
										, 'autocomplete' => 'off'
										, 'ng-model' => 'login.record.username'
										, 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
										, 'ng-change' => "login.checkUsername(login.record.username, futureed.STUDENT, futureed.FALSE)")
								) !!}
								<div class="check-ico">
									<span ng-if="login.validation.u_success" class="success-msg-con">
										Username address is available.
									</span>
								</div>
								<div class="reg-info"> 
									<i ng-if="login.validation.u_loading" class="fa fa-spinner fa-spin"></i>
									<span ng-if="login.validation.u_error" class="error-msg-con">{! login.validation.u_error !}</span>
								</div>
							</div>
							<label class="col-xs-2 control-label">Email<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('email', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
										, 'placeholder' => 'Email Address' 
										, 'autocomplete' => 'off'
										, 'ng-model' => 'login.record.email'
										, 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
										, 'ng-change' => "login.checkEmail(login.record.email, futureed.STUDENT, futureed.FALSE)")
								) !!}
								<div class="check-ico">
									<span ng-if="login.validation.e_success" class="success-msg-con">
										Email address is available.
									</span>
								</div>
								<div class="reg-info">
									<i ng-if="login.validation.e_loading" class="fa fa-spinner fa-spin"></i>
									<span ng-if="login.validation.e_error" class="error-msg-con">{! login.validation.e_error !}</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>School Information</legend>
						<div class="form-group" ng-if="login.record.invited">
							<label class="col-xs-2 control-label">School Name</label>
							<div class="col-xs-4">
								{!! Form::text('state', 'N/A'
									, array(
										'class' => 'form-control'
										, 'disabled' => 'true'
										, 'ng-model' => 'login.record.school_name')
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-2 control-label">School level</label>
							<div class="col-xs-4">
								<select name="grade_code" 
									ng-disabled="!grades.length" 
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
							{!! Form::button('Register'
								, array(
									'class' => 'btn btn-maroon btn-medium'
									, 'ng-click' => "login.validateRegistration()"
									, 'ng-show' => '!login.record.invited'
								)
							) !!}

							 {!! Form::button('Confirm Registration'
								, array(
									'class' => 'btn btn-maroon btn-medium'
									, 'ng-click' => "login.editRegistration()"
									, 'ng-show' => 'login.record.invited'
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
</div>