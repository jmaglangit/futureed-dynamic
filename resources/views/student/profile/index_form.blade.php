{!! Form::open(array('id' => 'profile_form', 'class' => 'form-horizontal', 'ng-if' => 'profile.active_index || profile.active_edit')) !!}
	<div class="alert alert-success" ng-if="profile.success">
		<p>{!! trans('messages.updated_your_profile') !!}</p>
	</div>
	
	<fieldset>
		<legend>{!! trans('messages.credentials_info') !!}</legend>
		<div class="form-group">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.username') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('username', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'trans('messages.username')' 
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-model' => 'profile.prof.username'
						, 'ng-class' => "{ 'required-field' : profile.fields['username']}"
						, 'ng-model-options' => "{debounce : {'default' : 1000} }"
						, 'ng-change' => "checkAvailability(profile.prof.username, 'Student')")
				) !!}
				<div class="prof-info"> 
					<i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
					<i ng-if="u_success" class="fa fa-check success-color"></i>
					<span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
				</div>
			</div>
			<label for="" class="col-xs-2 control-label">{!! trans('messages.email') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				<div class="input-group">
					{!! Form::text('email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => 'trans('messages.email_address')' 
							, 'readonly' => 'readonly'
							, 'ng-model' => 'profile.prof.email'
						)
					) !!}
					<span ng-if="!user.media_login" class="input-group-addon edit-addon" ng-click="profile.setStudentProfileActive('edit_email')"><i class="fa fa-pencil"></i></span>
					<span ng-if="user.media_login" class="input-group-addon edit-addon"><i class="fa fa-pencil disabled"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group" ng-if="profile.prof.new_email">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.pending_email') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('email', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'trans('messages.pending_email_address')' 
						, 'readonly' => 'readonly' 
						, 'ng-model' => 'profile.prof.new_email'
					)
				) !!}
			</div>
			<div class="col-xs-3">
				<a href="" ng-click="profile.setStudentProfileActive('confirm_email')" class="edit-email">{!! trans('messages.confirm_email') !!}</a>
			</div>	
		</div>
	</fieldset>					
	<fieldset>
		<legend>Personal Information</legend>
		<div class="form-group">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('first_name', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'trans('messages.first_name')'
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-class' => "{ 'required-field' : profile.fields['first_name']}"
						, 'ng-model' => 'profile.prof.first_name')
				) !!}
			</div>
			<label for="" class="col-xs-2 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('last_name', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'trans('messages.last_name')'
						, 'ng-disabled' => '!profile.active_edit' 
						, 'ng-class' => "{ 'required-field' : profile.fields['last_name']}"
						, 'ng-model' => 'profile.prof.last_name')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				<input type="hidden" id="birth_date">
			</div>
			<label for="" class="col-xs-1 control-label">{!! trans('messages.age') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('age', ''
					, array(
						'class' => 'form-control'
						, 'ng-disabled' => 'true'
						, 'placeholder' => 'trans('messages.age')' 
						, 'ng-model' => 'profile.prof.age')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.gender') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::select(''
					, array(
						'' => 'trans('messages.select_gender')'
						, 'Male' => 'trans('messages.male')'
						, 'Female' => 'trans('messages.female')'
					)
					, 'prof.gender'
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'profile.prof.gender'
						, 'ng-class' => "{ 'required-field' : profile.fields['gender']}"
						, 'ng-disabled' => '!profile.active_edit')
				) !!}
			</div>
			<label for="" class="col-xs-2 control-label">{!! trans('messages.state') !!}</span></label>
			<div class="col-xs-4">
				{!! Form::text('state', ''
					, array(
						'class' => 'form-control'
						, 'ng-disabled' => '!profile.active_edit'
						, 'placeholder' => 'trans('messages.state')' 
						, 'ng-class' => "{ 'required-field' : profile.fields['state']}"
						, 'ng-model' => 'profile.prof.state')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.city') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::text('city', ''
					, array(
						'class' => 'form-control'
						, 'ng-disabled' => '!profile.active_edit'
						, 'placeholder' => 'trans('messages.city')' 
						, 'ng-class' => "{ 'required-field' : profile.fields['city']}"
						, 'ng-model' => 'profile.prof.city')
				) !!}
			</div>
			<label for="" class="col-xs-2 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
			<div class="col-xs-4">
				<select class="form-control" name="country_id"
					ng-init="getCountries()"
					ng-model="profile.prof.country_id" 
					ng-change="profile.setCountryGrade()" 
					ng-disabled="!profile.active_edit"
					ng-class="{ 'required-field' : profile.fields['country_id'] || profile.fields['country']}">
					<option ng-selected="profile.prof.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
					<option ng-selected="profile.prof.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
				</select>
			</div>
		</div>
	</fieldset>					
	<fieldset>
		<legend>{!! trans('messages.school_info') !!}</legend>
		<div class="form-group" ng-if="prof.school_name">
			<label for="" class="col-xs-2 control-label">{!! trans('messages.school_name') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('school_name', ''
					, array(
						'class' => 'form-control'
						, 'ng-disabled' => '!profile.active_edit'
						, 'placeholder' => 'trans('messages.school_name')' 
						, 'ng-class' => "{ 'required-field' : profile.fields['first_name']}"
						, 'ng-model' => 'prof.school_name')
				) !!}
			</div>
		</div>
		<div class="form-group">
		<label for="" class="col-xs-2 control-label">{!! trans('messages.school_level') !!} <span class="required">*</span></label>

		<div class="col-xs-4 nullable">
			<select class="form-control" name="grade_code" 
				ng-model="profile.prof.grade_code" 
				ng-disabled="!profile.active_edit || profile.grades.length <= 0"
				ng-class="{ 'required-field' : profile.fields['grade_code']}">
				<option value="">{!! trans('messages.select_level') !!}</option>
				<option ng-selected="profile.prof.grade_code == grade.code" ng-repeat="grade in profile.grades" ng-value="grade.code">{! grade.name !}</option>
			</select>
		</div><br><br>
	</div>   
	</fieldset>
	<div class="form-group">
		<div class="btn-container">
			<div class="col-xs-9 col-xs-offset-2" ng-if="!profile.active_edit">
				{!! Form::button('trans('messages.student_change_picture_password')'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('password')"
					)
				) !!}

				{!! Form::button('trans('messages.edit_profile')'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('edit')"
					)
				) !!}
			</div>

			<div class="col-xs-9 col-xs-offset-2" ng-if="profile.active_edit">
				{!! Form::button('trans('messages.save_changes')'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.saveProfile()'
					)
				) !!}

				{!! Form::button('trans('messages.cancel')'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('index')"
					)
				) !!}
			</div>
		</div>
	</div>
	<div class="form-group"></div>
{!! Form::close() !!}