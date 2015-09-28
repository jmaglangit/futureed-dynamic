<div class="form-style registration-container form-wide" ng-if="login.active_confirm"> 
	<div class="title">Confirm Account as</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-3"></div>
			<div class="col-xs-3" ng-click="login.selectRole(futureed.PRINCIPAL)">
				{!! Html::image('/images/user_principal.png', 'Principal'
					, array(
						'id' => 'user_principal'
						, 'class' => 'client-reg-img'
						, 'ng-class' => '{ role : !login.principal }'
					)
				) !!}
				<h4>Principal</h4>
			</div>

			<div class="col-xs-3" ng-click="login.selectRole(futureed.PARENT)">
				{!! Html::image('/images/user_parent.png', 'Parent'
					, array(
						'id' => 'user_parent'
						, 'class' => 'client-reg-img'
						, 'ng-class' => '{ role : !login.parent }'
					)
				) !!}
				<h4>Parent</h4>
			</div>
		</div>

		<div class="col-xs-12" ng-if="login.record.client_role">
			<div class="alert alert-error" ng-if="login.errors">
				<p ng-repeat="error in login.errors track by $index"> 
					{! error !}
				</p>
			</div>

			{!! Form::open(array('id'=> 'add_age_group_form', 'class' => 'form-horizontal')) !!}
			<div class="col-xs-12 form-content">
					<fieldset>
						<legend class="legend">User Credentials</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Email<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('email', ''
									, array(
										'class' => 'form-control'
										, 'placeholder' => 'Email Address'
										, 'ng-model' => 'login.record.email'
										, 'ng-disabled' => 'true'
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
										, 'ng-model' => 'login.record.last_name'
									)
								) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-2 control-label">Street Address<span class="required" ng-if="login.required">*</span></label>
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
							<label class="col-xs-2 control-label">City<span class="required" ng-if="login.required">*</span></label>
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

							<label class="col-xs-2 control-label">Country<span class="required" ng-if="login.required">*</span></label>
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

					<div ng-if="login.principal" class="role-div">
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
				{!! Form::close() !!}
			</div>
		</div>

		<div class="block_bottom" ng-if="login.record.client_role">
			<fieldset>
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

				<div class="btn-container col-xs-6 col-xs-offset-3">
					{!! Form::button('Login', 
						array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'login.confirmMediaDetails()'
						)
					) !!}

					{!! Html::link(route('client.login'), 'Cancel', 
						array(
							'class' => 'btn btn-gold btn-medium'
						)
					) !!}
				</div>
			</fieldset>
		</div>
	</div>

	@include('client.login.terms-and-conditions')

	@include('student.login.privacy-policy')
</div>

<div ng-if="login.active_confirm_success">
	<div class="registration-container form-style form-narrow">
		<div class="logo-container">
			{!! Html::image('/images/logo-md.png') !!}
		</div>

		<div class="title title-student">Registration Success</div>

		<div class="alert alert-success">
			<p> Your email account has been successfully confirmed. </p>
		</div>

		<h4 class="title">
			You will be receiving an email shortly by our Admin if your registration has been approved or not.
		</h4>

		<small> 
			If you have not yet receive the email, please check your inbox or your spam folder.
		</small>
		
		{!! Html::link(route('client.login'), 'Click here to Login'
			, array(
			'class' => 'btn btn-blue btn-medium'
			) 
		) !!}
	</div>
</div>
