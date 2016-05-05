<div class="form-style registration-container form-wide" ng-if="login.active_confirm"> 
	<div class="title">{!! trans('messages.client_confirm_as') !!}</div>
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
				<h4>{!! trans('messages.principal') !!}</h4>
			</div>

			<div class="col-xs-3" ng-click="login.selectRole(futureed.PARENT)">
				{!! Html::image('/images/user_parent.png', 'Parent'
					, array(
						'id' => 'user_parent'
						, 'class' => 'client-reg-img'
						, 'ng-class' => '{ role : !login.parent }'
					)
				) !!}
				<h4>{!! trans('messages.parent') !!}</h4>
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
						<legend class="legend">{!! trans('messages.user_credentials') !!}</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.username') !!}<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('username', ''
									, array(
										'class' => 'form-control'
										, 'autocomplete' => 'off'
										, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
										, 'placeholder' => trans('messages.username')
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
							
							<label class="col-xs-2 control-label">{!! trans('messages.email') !!}<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('email', ''
									, array(
										'class' => 'form-control'
										, 'placeholder' => trans('messages.email_address')
										, 'ng-model' => 'login.record.email'
										, 'ng-disabled' => 'true'
									)
								) !!}
							</div>
						</div> 
					</fieldset>

					<fieldset>
						<legend>{!! trans('messages.personal_info') !!}</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.first_name') !!}<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('first_name', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
										, 'placeholder' => trans('messages.first_name')
										, 'ng-model' => 'login.record.first_name'
									)
								) !!}
							</div>
							<label class="col-xs-2 control-label">{!! trans('messages.last_name') !!}<span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('last_name', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
										, 'placeholder' => trans('messages.last_name')
										, 'ng-model' => 'login.record.last_name'
									)
								) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.street_address') !!}<span class="required" ng-if="login.required">*</span></label>
							<div class="col-xs-6">
								{!! Form::text('street_address', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['street_address'] }"
									, 'placeholder' => trans('messages.street_address')
									, 'ng-model' => 'login.record.street_address'
								)
								) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.city') !!}<span class="required" ng-if="login.required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('city', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['city'] }"
										, 'placeholder' => trans('messages.city')
										, 'ng-model' => 'login.record.city'
									)
								) !!}
							</div>
							<label class="col-xs-2 control-label">{!! trans('messages.state') !!}</label>
							<div class="col-xs-4">
								{!! Form::text('state', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['state'] }"
										, 'placeholder' => trans('messages.state')
										, 'ng-model' => 'login.record.state'
									)
								) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.postal_code') !!}</label>
							<div class="col-xs-4">
								{!! Form::text('zip', ''
									, array(
										'class' => 'form-control'
										, 'ng-class' => "{ 'required-field' : login.fields['zip'] }"
										, 'placeholder' => trans('messages.postal_code')
										, 'ng-model' => 'login.record.zip'
									)
								) !!}
							</div>

							<label class="col-xs-2 control-label">{!! trans('messages.country') !!}<span class="required" ng-if="login.required">*</span></label>
							<div class="col-xs-4" ng-init="getCountries()">
								<select  name="country_id" 
									class="form-control" 
									ng-class="{ 'required-field' : login.fields['country_id'] }"
									ng-model="login.record.country_id">
									<option value="">{!! trans('messages.select_country') !!}</option>
									<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
								</select>
							</div>
						</div>
					</fieldset>

					<div ng-if="login.principal" class="role-div">
						<fieldset>
							<legend>{!! trans('messages.school_info') !!}</legend>
							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.school_name') !!}<span class="required">*</span></label>
								<div class="col-xs-6">
									{!! Form::text('school_name', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['school_name'] }"
											, 'placeholder' => trans('messages.school_name')
											, 'ng-model' => 'login.record.school_name'
										)
									) !!}
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.school_address') !!}<span class="required">*</span></label>
								<div class="col-xs-6">
									{!! Form::text('school_address', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['school_address'] }"
											, 'placeholder' => trans('messages.school_address')
											, 'ng-model' => 'login.record.school_address'
										)
									) !!}
								</div>
							</div>

							<div class="form-group">
							<label class="col-xs-2 control-label">{!! trans('messages.city') !!}</label>
								<div class="col-xs-4">
									{!! Form::text('school_city', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['school_city'] }"
											, 'placeholder' => trans('messages.city')
											, 'ng-model' => 'login.record.school_city'
										)
									) !!}
								</div>
								<label class="col-xs-2 control-label">{!! trans('messages.state') !!}<span class="required">*</span></label>
								<div class="col-xs-4">
									{!! Form::text('school_state', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['school_state'] }"
											, 'placeholder' => trans('messages.state')
											, 'ng-model' => 'login.record.school_state'
										)
									) !!}
								</div>
							</div>  

							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.postal_code') !!}</label>
								<div class="col-xs-4">
									{!! Form::text('school_zip', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['school_zip'] }"
											, 'placeholder' => trans('messages.postal_code')
											, 'ng-model' => 'login.record.school_zip'
										)
									) !!}
								</div>

								<label class="col-xs-2 control-label">{!! trans('messages.country') !!}<span class="required">*</span></label>
								<div class="col-xs-4" ng-init="getCountries()">
									<select  name="school_country_id" 
										class="form-control" 
										ng-class="{ 'required-field' : login.fields['school_country_id'] }"
										ng-model="login.record.school_country_id">
										<option value="">{!! trans('messages.select_country') !!}</option>
										<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
									</select>
								</div>
							</div> 

							<legend>{!! trans('messages.school_contact_info') !!}</legend>
							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.contact_person') !!}<span class="required">*</span></label>
								<div class="col-xs-6">
									{!! Form::text('contact_name', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['contact_name'] }"
											, 'placeholder' => trans('messages.contact_person')
											, 'ng-model' => 'login.record.contact_name'
										)
									) !!}
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.contact_number') !!}<span class="required">*</span></label>
								<div class="col-xs-6">
									{!! Form::text('contact_number', ''
										, array(
											'class' => 'form-control'
											, 'ng-class' => "{ 'required-field' : login.fields['contact_number'] }"
											, 'placeholder' => trans('messages.contact_number')
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

						{!! Html::link('#', trans('messages.terms_and_conditions')
							, array(
								'ng-click' => "showModal('terms_modal')"
								, 'data-toggle' => 'modal'
							)
						) !!}

						and 

						{!! Html::link('#', trans('messages.data_privacy_policy')
							, array(
								'ng-click' => "showModal('policy_modal')"
								, 'data-toggle' => 'modal'
							)
						) !!}
					</label>
				</div>

				<div class="btn-container col-xs-6 col-xs-offset-3">
					{!! Form::button(trans('messages.login'),
						array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'login.confirmMediaDetails()'
						)
					) !!}

					{!! Html::link(route('client.login'), trans('messages.cancel'),
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

		<div class="title title-student">{!! trans('messages.registration_success') !!}</div>

		<div class="alert alert-success">
			<p>{!! trans('messages.client_registration_success_msg') !!}</p>
		</div>

		<h4 class="title">
			{!! trans('messages.client_registration_success_msg2') !!}
		</h4>

		<small> 
			{!! trans('messages.client_registration_success_msg3') !!}
		</small>
		
		<div class="form-group">
			{!! Html::link(route('client.login'), trans('messages.click_to_login')
				, array(
				'class' => 'btn btn-blue btn-medium'
				) 
			) !!}
		</div>
	</div>
</div>
