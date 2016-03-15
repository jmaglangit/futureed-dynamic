{!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal')) !!}
	<fieldset>
		<legend>User Credentials</legend>
		<div class="form-group">
			<label class="col-xs-2 control-label">Email<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('email', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['email'] }"
						, 'placeholder' => 'Email Address'
						, 'ng-model' => 'login.record.email'
						, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
						, 'ng-change' => "login.checkEmail(login.record.email, futureed.CLIENT, futureed.FALSE)"
					)
				) !!}

				<div>
					<span ng-if="login.validation.e_error" class="error-msg-con">{! login.validation.e_error !}</span>
					<i ng-if="login.validation.e_loading" class="fa fa-spinner fa-spin"></i>
					<span ng-if="login.validation.e_success" class="error-msg-con success-color">{! futureed.MSG_EA_AVAILABLE !}</span>
				</div>
			</div>

			<label class="col-xs-2 control-label">Username<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('username', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
						, 'placeholder' => 'Username'
						, 'ng-model' => 'login.record.username'
						, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
						, 'ng-change' => "login.checkUsername(login.record.username, futureed.CLIENT, futureed.FALSE)"
					)
				) !!}
				
				<div> 
					<span ng-if="login.validation.u_error" class="error-msg-con">{! login.validation.u_error !}</span>
					<i ng-if="login.validation.u_loading" class="fa fa-spinner fa-spin"></i>
					<span ng-if="login.validation.u_success" class="error-msg-con success-color">{! futureed.MSG_U_AVAILABLE !}</span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label">Password<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('password'
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['password'] }"
						, 'placeholder' => 'Password'
						, 'ng-model' => 'login.record.password'
					)
				) !!}
			<p class="help-block">{! futureed.PASSWORD_TIP !}</p>
			</div>
		<label class="col-xs-2 control-label">Confirm Password<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('confirm_password'
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['password'] }"
						, 'placeholder' => 'Confirm Password'
						, 'ng-model' => 'login.record.confirm_password'
					)
				) !!}
			</div>
		</div>   
	</fieldset>

	<fieldset>
		<legend>Personal Information</legend>
		<div class="form-group">
			<label class="col-xs-2 control-label">First Name<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('first_name', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
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
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
						, 'placeholder' => 'Last Name'
						, 'ng-model' => 'login.record.last_name'
					)
				) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label">Street Address</label>
			<div class="col-xs-6">
				{!! Form::text('street_address', ''
				, array(
					'class' => 'form-control'
					, 'ng-class' => "{ 'required-field' : login.fields['street_address'] }"
					, 'placeholder' => 'Street Address'
					, 'ng-model' => 'login.record.street_address'
				)
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
						, 'ng-model' => 'login.record.city'
					)
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

		<div class="form-group">
			<label class="col-xs-2 control-label">Postal Code</label>
			<div class="col-xs-4">
				{!! Form::text('zip', ''
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['zip'] }"
						, 'placeholder' => 'Postal Code'
						, 'ng-model' => 'login.record.zip'
					)
				) !!}
			</div>

			<label class="col-xs-2 control-label">Country</label>
			<div class="col-xs-4" ng-init="getCountries()">
				<select  name="country_id" 
					class="form-control" 
					ng-class="{ 'required-field' : login.fields['country_id'] }"
					ng-model="login.record.country_id">
					<option value="">-- Select Country --</option>
					<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				</select>
			</div>
		</div>
	</fieldset>

	<div id="principal" ng-if="login.principal" class="role-div">
		<fieldset>
			<legend>School Information</legend>
			<div class="form-group">
				<label class="col-xs-2 control-label">School Name<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('school_name', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_name'] }"
							, 'placeholder' => 'School Name'
							, 'ng-model' => 'login.record.school_name'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-2 control-label">School Address<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('school_address', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_address'] }"
							, 'placeholder' => 'School Address'
							, 'ng-model' => 'login.record.school_address'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
			<label class="col-xs-2 control-label">City</label>
				<div class="col-xs-4">
					{!! Form::text('school_city', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_city'] }"
							, 'placeholder' => 'City'
							, 'ng-model' => 'login.record.school_city'
						)
					) !!}
				</div>
				<label class="col-xs-2 control-label">State<span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('school_state', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_state'] }"
							, 'placeholder' => 'State'
							, 'ng-model' => 'login.record.school_state'
						)
					) !!}
				</div>
			</div>  

			<div class="form-group">
				<label class="col-xs-2 control-label">Postal Code</label>
				<div class="col-xs-4">
					{!! Form::text('school_zip', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_zip'] }"
							, 'placeholder' => 'Postal Code'
							, 'ng-model' => 'login.record.school_zip'
						)
					) !!}
				</div>

				<label class="col-xs-2 control-label">Country<span class="required">*</span></label>
				<div class="col-xs-4" ng-init="getCountries()">
					<select  name="school_country_id" 
						class="form-control" 
						ng-class="{ 'required-field' : login.fields['school_country_id'] }"
						ng-model="login.record.school_country_id">
						<option value="">-- Select Country --</option>
						<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
					</select>
				</div>
			</div> 

			<legend>School Contact Information</legend>
			<div class="form-group">
				<label class="col-xs-2 control-label">Contact Person<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('contact_name', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['contact_name'] }"
							, 'placeholder' => 'Contact Person'
							, 'ng-model' => 'login.record.contact_name'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-2 control-label">Contact Number<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('contact_number', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['contact_number'] }"
							, 'placeholder' => 'Contact Number'
							, 'ng-model' => 'login.record.contact_number'
						)
					) !!}
				</div>
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

			<div class="btn-container col-xs-6 col-xs-offset-3">
				<a ng-click="login.registerClient()" type="button" class="btn btn-blue btn-medium">Register</a>
				<a href="{!! route('client.login') !!}" type="button" class="btn btn-gold btn-medium">Cancel</a>
			</div>
		</fieldset>
	</div>
{!! Form::close() !!}