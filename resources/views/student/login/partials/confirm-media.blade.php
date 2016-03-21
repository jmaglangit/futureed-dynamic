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
								<h3 class="box-title">{!! trans('messages.register') !!} {! login.record.media_type !} {!! trans('messages.detail') !!}</h3>
								<div class="info-box rd">
									<h4>{!! trans('messages.for_students_13_years') !!}</h4>
									<p>{!! trans('messages.parent_should_register') !!} {!! Html::link(route('client.registration'), 'trans('messages.here')') !!} {!! trans('messages.to_register') !!}</p>
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

				<div>(<span class="required">*</span> ) {!! trans('messages.indicate_required_field') !!}</div>
				<fieldset>
					<legend>{!! trans('messages.personal_info') !!}</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.birthday') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							<input type="hidden" id="birth_date" 
								onchange="checkAge()"
								ng-init="login.setDropdown(login.record.birth_date)">
						</div>
						<label class="col-xs-2 control-label">{!! trans('messages.gender') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::select('gender'
								, array(
									'' => 'trans('messages.select_gender')'
									, 'Male' => 'trans('messages.male')'
									, 'Female' => 'trans('messages.female')'
								)
								, ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['gender'] }"
									, 'ng-model' => 'login.record.gender')
							); !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.first_name') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('first_name', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
									, 'placeholder' => 'trans('messages.first_name')' 
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
									, 'placeholder' => 'trans('messages.last_name')' 
									, 'ng-model' => 'login.record.last_name')
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.city') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('city', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['city'] }"
									, 'placeholder' => 'trans('messages.city')' 
									, 'ng-model' => 'login.record.city')
							) !!}
						</div>
						<label class="col-xs-2 control-label">{!! trans('messages.state') !!}</label>
						<div class="col-xs-4">
							{!! Form::text('state', ''
								, array(
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : login.fields['state'] }"
									, 'placeholder' => 'trans('messages.state')' 
									, 'ng-model' => 'login.record.state'
								)
							) !!}
						</div>
					</div>
					<div class="form-group" ng-init="getCountries()">
						<label class="col-xs-2 control-label">{!! trans('messages.country') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							<select name="country_id" id="country" class="form-control" 
								ng-class="{ 'required-field' : login.fields['country_id'] }"
								ng-model="login.record.country_id" 
								ng-change="getGradeLevel(login.record.country_id)">
								<option value="">{!! trans('messages.select_country') !!}</option>
								<option ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>{!! trans('messages.user_credentials') !!}</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.username') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('username', ''
								, array(
									'class' => 'form-control'
									, 'autocomplete' => 'off'
									, 'ng-class' => "{ 'required-field' : login.fields['username'] }"
									, 'placeholder' => 'trans('messages.username')'
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
									, 'placeholder' => 'trans('messages.email_address')' 
									, 'ng-model' => 'login.record.email'
									, 'ng-disabled' => 'true'
								)
							) !!}
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>{!! trans('messages.school_info') !!}</legend>
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.school_level') !!}<span class="required">*</span></label>
						<div class="col-xs-4">
							<select name="grade_code" ng-disabled="!grades.length" 
								class="form-control"
								ng-class="{ 'required-field' : login.fields['grade_code'] }"
								ng-model="login.record.grade_code">
								<option value="">{!! trans('messages.select_level') !!}</option>
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
								
								{!! trans('messages.i_agree') !!}

								{!! Html::link('#', 'trans('messages.terms_and_conditions')'
									, array(
										'ng-click' => "showModal('terms_modal')"
										, 'data-toggle' => 'modal'
									)
								) !!}

								 and 

								{!! Html::link('#', 'trans('messages.data_privacy_policy')'
									, array(
										'ng-click' => "showModal('policy_modal')"
										, 'data-toggle' => 'modal'
									)
								) !!}
							</label>
						</div>
					</div>
					<div class="btn-container col-sm-6 col-sm-offset-3">
						{!! Form::button('trans('messages.confirm')'
							, array(
								'class' => 'btn btn-maroon btn-medium'
								, 'ng-click' => "login.confirmMediaDetails()"
							)
						) !!}

						{!! Html::link(route('student.login'), 'trans('messages.cancel')'
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
					<h5>{!! trans('messages.student_13_years_old_younger') !!} <a href="{!! route('client.registration') !!}">{!! trans('messages.client_site') !!}</a></h5>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button('trans('messages.cancel')'
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

		<div class="title title-student">{!! trans('messages.registration_success') !!}</div>

		<div class="alert alert-success">
			<p> {!! trans('messages.you_have_successfully_registered') !!}</p>
		</div>

		<div class="form-group">
			{!! Form::button('trans('messages.proceed_to_dashboard')' 
			, array(
				  'class' => 'btn btn-maroon btn-medium'
				, 'ng-click' => 'login.proceedToDashboard()'
				)
			) !!}
		</div>
	</div>
</div>
