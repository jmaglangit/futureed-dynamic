{!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal')) !!}
<div id="clientReg">
	<fieldset>
		<legend>{!! trans('messages.user_credentials') !!}</legend>
		<div class="form-group">
			<label class="col-xs-2 control-label">{!! trans('messages.email') !!}<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('email', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['email'] }"
						, 'placeholder' => trans('messages.email_address')
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
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label">{!! trans('messages.password') !!}<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('password'
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['password'] }"
						, 'placeholder' => trans('messages.password')
						, 'ng-model' => 'login.record.password'
					)
				) !!}
			<p class="help-block">{! futureed.PASSWORD_TIP !}</p>
			</div>
		<label class="col-xs-2 control-label">{!! trans('messages.confirm_password') !!}<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('confirm_password'
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['password'] }"
						, 'placeholder' => trans('messages.confirm_password')
						, 'ng-model' => 'login.record.confirm_password'
					)
				) !!}
			</div>
		</div>   
	</fieldset>

	<fieldset>
		<legend>{!! trans('messages.personal_info') !!}</legend>
		<div class="form-group" ng-form name="personalInfo">
			<label class="col-xs-2 control-label">{!! trans('messages.first_name') !!}<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('first_name', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
						, 'placeholder' => trans('messages.first_name')
						, 'ng-maxlength' => '64'
						, 'ng-minlength' => '3'
						, 'ng-click' => 'login.validateMaxLength()'
						, 'ng-model' => 'login.record.first_name'
					)
				) !!}
				<div class="reg-info">
					<span class="error-msg-con" ng-show="personalInfo.first_name.$error.maxlength">{!! trans('messages.register_firstname_may_not_be_greater') !!}</span>
					<span class="error-msg-con" ng-show="personalInfo.first_name.$error.minlength">{!! trans('messages.register_firstname_must_not_be_at_least') !!}</span>
				</div>
			</div>
			<label class="col-xs-2 control-label">{!! trans('messages.last_name') !!}<span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('last_name', ''
					, array(
						'class' => 'form-control'
						, 'autocomplete' => 'off'
						, 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
						, 'placeholder' => trans('messages.last_name')
						, 'ng-maxlength' => '64'
						, 'ng-minlength' => '3'
						, 'ng-click' => 'login.validateMaxLength()'
						, 'ng-model' => 'login.record.last_name'
					)
				) !!}
				<div class="reg-info">
					<span class="error-msg-con" ng-show="personalInfo.last_name.$error.maxlength">{!! trans('messages.register_lastname_may_not_be_greater') !!}</span>
					<span class="error-msg-con" ng-show="personalInfo.last_name.$error.minlength">{!! trans('messages.register_lastname_must_not_be_at_least') !!}</span>
				</div>
			</div>
		</div>

		<div class="form-group" ng-form name="streetInfo">
			<label class="col-xs-2 control-label">{!! trans('messages.street_address') !!}</label>
			<div class="col-xs-6">
				{!! Form::text('street_address', ''
				, array(
					'class' => 'form-control'
					, 'ng-class' => "{ 'required-field' : login.fields['street_address'] }"
					, 'placeholder' => trans('messages.street_address')
					, 'ng-maxlength' => '128'
					, 'ng-click' => 'login.validateMaxLength()'
					, 'ng-model' => 'login.record.street_address'
				)
				) !!}
				<div class="reg-info">
					<span class="error-msg-con" ng-show="streetInfo.street_address.$error.maxlength">{!! trans('messages.register_street_address_may_not_be_greater') !!}</span>
				</div>
			</div>
		</div>

		<div class="form-group" ng-form name="addressInfo">
			<label class="col-xs-2 control-label">{!! trans('messages.city') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('city', ''
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['city'] }"
						, 'placeholder' => trans('messages.city')
						, 'ng-maxlength' => '128'
						, 'ng-click' => 'login.validateMaxLength()'
						, 'ng-model' => 'login.record.city'
					)
				) !!}
				<div class="reg-info">
					<span class="error-msg-con" ng-show="addressInfo.city.$error.maxlength">{!! trans('messages.register_city_may_not_be_greater') !!}</span>
				</div>
			</div>
			<label class="col-xs-2 control-label">{!! trans('messages.state') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('state', ''
					, array(
						'class' => 'form-control'
						, 'ng-class' => "{ 'required-field' : login.fields['state'] }"
						, 'placeholder' => trans('messages.state')
						, 'ng-maxlength' => '128'
						, 'ng-click' => 'login.validateMaxLength()'
						, 'ng-model' => 'login.record.state'
					)
				) !!}
				<div class="reg-info">
					<span class="error-msg-con" ng-show="addressInfo.state.$error.maxlength">{!! trans('messages.register_state_may_not_be_greater') !!}</span>
				</div>
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

			<label class="col-xs-2 control-label">{!! trans('messages.country') !!}</label>
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

	<div id="principal" ng-if="login.principal" class="role-div">
		<fieldset>
			<legend>{!! trans('messages.school_info') !!}</legend>
			<div class="form-group"  ng-form name="schoolName">
				<label class="col-xs-2 control-label">{!! trans('messages.school_name') !!}<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('school_name', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_name'] }"
							, 'placeholder' => trans('messages.school_name')
							, 'ng-maxlength' => '128'
							, 'ng-click' => 'login.validateMaxLength()'
							, 'ng-model' => 'login.record.school_name'
						)
					) !!}
				</div>
				<div class="reg-info">
					<span class="error-msg-con" ng-show="schoolName.school_name.$error.maxlength">{!! trans('messages.register_school_name_may_not_be_greater') !!}</span>
				</div>
			</div>

			<div class="form-group" ng-form name="schoolAddress">
				<label class="col-xs-2 control-label">{!! trans('messages.school_address') !!}<span class="required">*</span></label>
				<div class="col-xs-6">
					{!! Form::text('school_address', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_address'] }"
							, 'placeholder' => trans('messages.school_address')
							, 'ng-maxlength' => '128'
							, 'ng-click' => 'login.validateMaxLength()'
							, 'ng-model' => 'login.record.school_address'
						)
					) !!}
					<div class="reg-info">
						<span class="error-msg-con" ng-show="schoolAddress.school_address.$error.maxlength">{!! trans('messages.register_school_address_may_not_be_greater') !!}</span>
					</div>
				</div>
			</div>

			<div class="form-group" ng-form name="schoolInfo">
			<label class="col-xs-2 control-label">{!! trans('messages.city') !!}</label>
				<div class="col-xs-4">
					{!! Form::text('school_city', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_city'] }"
							, 'placeholder' => trans('messages.city')
							, 'ng-maxlength' => '128'
							, 'ng-click' => 'login.validateMaxLength()'
							, 'ng-model' => 'login.record.school_city'
						)
					) !!}
					<div class="reg-info">
						<span class="error-msg-con" ng-show="schoolInfo.school_city.$error.maxlength">{!! trans('messages.register_school_city_may_not_be_greater') !!}</span>
					</div>
				</div>
				<label class="col-xs-2 control-label">{!! trans('messages.state') !!}<span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('school_state', ''
						, array(
							'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : login.fields['school_state'] }"
							, 'placeholder' => trans('messages.state')
							, 'ng-maxlength' => '128'
							, 'ng-click' => 'login.validateMaxLength()'
							, 'ng-model' => 'login.record.school_state'
						)
					) !!}
					<div class="reg-info">
						<span class="error-msg-con" ng-show="schoolInfo.school_state.$error.maxlength">{!! trans('messages.register_school_state_may_not_be_greater') !!}</span>
					</div>
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
</div>
	<div class="block_bottom">
		<fieldset>
			<div class="form-group">
				<div class="checkbox text-center">
					<label>
						{!! Form::checkbox('terms', 1, null, array('ng-model' => 'login.record.terms')) !!}

						{{ trans('messages.i_agree') }}

						{!! Html::link('#', trans('messages.terms_and_conditions')
							, array(
								'ng-click' => "showModal('terms_modal')"
								, 'data-toggle' => 'modal'
							)
						) !!}

						{{ trans('messages.and') }}

						{!! Html::link('#', trans('messages.data_privacy_policy')
							, array(
								'ng-click' => "showModal('policy_modal')"
								, 'data-toggle' => 'modal'
							)
						) !!}
					</label>
				</div>
			</div>

			<div class="btn-container col-xs-6 col-xs-offset-3">
				<a ng-click="login.registerClient()" type="button" class="btn btn-blue btn-medium">{!! trans('messages.register') !!}</a>
				<a href="{!! route('client.login') !!}" type="button" class="btn btn-gray btn-medium">{!! trans('messages.cancel') !!}</a>
			</div>
		</fieldset>
	</div>
{!! Form::close() !!}