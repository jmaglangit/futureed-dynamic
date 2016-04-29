{!! Form::open(array('id' => 'client_profile_form', 'class' => 'form-horizontal', 'ng-if' => 'profile.active_index || profile.active_edit')) !!}
	<fieldset>
		<legend class="legend-name-mid">
			{!! trans('messages.user_credentials') !!}
		</legend>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.username') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('username', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.username')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.username'
						, 'ng-model-options' => "{debounce : {'default' : 1000} }"
						, 'ng-change' => 'profile.checkAvailability()'
					)
				) !!}
			</div>
			<div style="margin-top: 7px;"> 
				<i ng-if="profile.validation.u_loading" class="fa fa-spinner fa-spin"></i>
				<i ng-if="profile.validation.u_success" class="fa fa-check success-color"></i>
				<span ng-if="profile.validation.u_error" class="error-msg-con">{! profile.validation.u_error !}</span>

			</div>		
		</div>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.email') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				<div class="input-group"> 
					{!! Form::text('email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.email_address')
							, 'readonly' => 'readonly' 
							, 'ng-model' => 'profile.prof.email'
						)
					) !!}

					<span class="input-group-addon" ng-click="profile.setClientProfileActive('edit_email')"><i class="fa fa-pencil edit-addon"></i></span>
				</div>
			</div>
		</div>
		
		<div class="form-group" ng-if='profile.prof.new_email'>
			<label for="" class="col-xs-3 control-label" style="color:#7F7504">{!! trans('messages.pending_email') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('email', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.email_address')
						, 'readonly' => 'readonly' 
						, 'ng-model' => 'profile.prof.new_email'
					)
				) !!}
			</div>
			<div class="col-xs-2">
				<a href="" ng-click="profile.setClientProfileActive('confirm_email')" class="edit-email">{!! trans('messages.confirm') !!}</a>
			</div>	
		</div>
	</fieldset>

	<fieldset>
		<legend class="legend-name-mid">
			{!! trans('messages.personal_info') !!}
		</legend>
		<div class="form-group">
				<label for="" class="col-xs-3 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('first_name', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.first_name')
							, 'ng-disabled' => '!profile.active_edit' 
							, 'ng-model' => 'profile.prof.first_name')
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-xs-3 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('last_name', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.last_name')
							, 'ng-disabled' => '!profile.active_edit' 
							, 'ng-model' => 'profile.prof.last_name')
					) !!}
				</div>
			</div>
	</fieldset>

	<fieldset ng-if="profile.is_teacher">
		<legend class="legend-name-mid">
			{!! trans('messages.school_info') !!}
		</legend>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('school_name', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.school_name')
						, 'ng-disabled' => 'true' 
						, 'ng-model' => 'profile.prof.school_name')
				) !!}
			</div>
		</div>
	</fieldset>

	<fieldset ng-if="profile.is_principal">
		<legend class="legend-name-mid">
			{!! trans('messages.school_info') !!}
		</legend>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('school_name', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.school_name')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.school_name')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.street_address') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('school_street_address', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.street_address')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.school_street_address')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.city') !!} </label>
			<div class="col-xs-3">
				{!! Form::text('school_city', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.city')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.school_city')
				) !!}
			</div>
			<label for="" class="col-xs-3 control-label">{!! trans('messages.state') !!} <span class="required">*</span></label>
			<div class="col-xs-3">
				{!! Form::text('school_state', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.state')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.school_state')
				) !!}
			</div>
		</div>
		<div class="form-group" ng-init="getCountries()">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.postal_code') !!}</label>
			<div class="col-xs-3">
				{!! Form::text('school_zip', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.postal_code')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.school_zip')
				) !!}
			</div>
			<label for="" class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
			<div class="col-xs-3">
				<select name="school_country_id" class="form-control" ng-model="profile.prof.school_country_id" ng-disabled="!profile.active_edit">
					<option ng-selected="profile.prof.school_country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
					<option ng-selected="profile.prof.school_country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				</select>
			</div>
		</div>
		<legend class="legend-name-mid">
			{!! trans('messages.school_contact_info') !!}
		</legend>
		<div class="form-group">
			<label class="col-xs-3 control-label">{!! trans('messages.contact_person') !!} <span class="required">*</span></label>
			<div class="col-xs-6">
			  {!! Form::text('school_contact_name', ''
				  , array(
					'class' => 'form-control'
					, 'placeholder' => trans('messages.contact_person')
					, 'ng-disabled' => '!profile.active_edit' 
					, 'ng-model' => 'profile.prof.school_contact_name'
				  )
			  ) !!}
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-xs-3 control-label">{!! trans('messages.contact_number') !!} <span class="required">*</span></label>
			<div class="col-xs-6">
			  {!! Form::text('school_contact_number', ''
				  , array(
					'class' => 'form-control'
					, 'placeholder' => trans('messages.contact_number')
					, 'ng-disabled' => '!profile.active_edit' 
					, 'ng-model' => 'profile.prof.school_contact_number'
				  )
			  ) !!}
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend class="legend-name-mid" ng-if="!profile.is_parent">
			{!! trans('messages.other_address_info') !!}
		</legend>
		<legend class="legend-name-mid" ng-if="profile.is_parent">
			{!! trans('messages.address_info') !!}
		</legend>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.street_address') !!} <span class="required" ng-if="profile.is_required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('street_address', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.street_address')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.street_address')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.city') !!} <span class="required" ng-if="profile.is_required">*</span></label>
			<div class="col-xs-3">
				{!! Form::text('city', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.city')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.city')
				) !!}
			</div>
			<label for="" class="col-xs-3 control-label">{!! trans('messages.state') !!} </label>
			<div class="col-xs-3">
				{!! Form::text('state', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.state')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.state')
				) !!}
			</div>
		</div>
		<div class="form-group" ng-init="getCountries()">
			<label for="" class="col-xs-3 control-label">{!! trans('messages.postal_code') !!} </label>
			<div class="col-xs-3">
				{!! Form::text('zip', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.postal_code')
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.zip')
				) !!}
			</div>
			<label for="" class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required" ng-if="profile.is_required">*</span></label>
			<div class="col-xs-3">
				<select name="country_id" class="form-control" ng-model="profile.prof.country_id" ng-disabled="!profile.active_edit">
					<option ng-selected="profile.prof.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
					<option ng-selected="profile.prof.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				</select>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<div class="form-group">
			<div class="btn-container">
				{!! Form::button(trans('messages.edit')
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "profile.setClientProfileActive('edit')"
						, 'ng-if' => '!profile.active_edit'
					)
				) !!}

				{!! Form::button(trans('messages.save')
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => 'profile.saveClientProfile()'
						, 'ng-if' => 'profile.active_edit'
					)
				) !!}

				{!! Form::button(trans('messages.cancel')
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setClientProfileActive('index')"
						, 'ng-if' => 'profile.active_edit'
					)
				) !!}
			</div>
		</div>
	</fieldset>
{!! Form::close() !!}