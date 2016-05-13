<div ng-if="student.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_student') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="student.success">
			<p>{! student.success !}</p>
		</div>
	</div>
	
	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'add_student_form', 'class' => 'form-horizontal')) !!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.user_credentials') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="username">{!! trans('messages.username') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('username',''
							, array(
								'placeHolder' => trans('messages.username')
								, 'ng-model' => 'student.record.username'
								, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
								, 'ng-change' => 'student.checkUsername(student.record.username, futureed.STUDENT, futureed.FALSE)'
								, 'ng-class' => "{ 'required-field' : student.fields['username'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					<div class="margin-top-8"> 
						<i ng-if="student.validation.u_loading" class="fa fa-spinner fa-spin"></i>
						<i ng-if="student.validation.u_success" class="fa fa-check success-color"></i>
						<span ng-if="student.validation.u_error" class="error-msg-con">{! student.validation.u_error !}</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('email',''
							, array(
								'placeHolder' => trans('messages.email')
								, 'ng-model' => 'student.record.email'
								, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
								, 'ng-change' => 'student.checkEmail(student.record.email, futureed.STUDENT, futureed.FALSE)'
								, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					<div class="margin-top-8"> 
						<i ng-if="student.validation.e_loading" class="fa fa-spinner fa-spin"></i>
						<i ng-if="student.validation.e_success" class="fa fa-check success-color"></i>
						<span ng-if="student.validation.e_error" class="error-msg-con">{! student.validation.e_error !}</span>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="status">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="col-xs-6 checkbox">
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, false
									, array(
										'class' => 'field'
										, 'ng-model' => 'student.record.status'
									)
								) !!}
							<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
							</label>
						</div>
						<div class="col-xs-6 checkbox">
							<label>
								{!! Form::radio('status'
									, 'Disabled'
									, false
									, array(
										'class' => 'field'
										, 'ng-model' => 'student.record.status'
									)
								) !!}
							<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.personal_info') !!}
				</legend>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('first_name','',
							array('class' => 'form-control'
									, 'ng-model' => 'student.record.first_name'
									, 'ng-class' => "{ 'required-field' : student.fields['first_name'] }"
									, 'placeHolder' => trans('messages.first_name')
								 )
							)!!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('last_name','',
							array('class' => 'form-control'
									, 'ng-model' => 'student.record.last_name'
									, 'ng-class' => "{ 'required-field' : student.fields['last_name'] }"
									, 'placeHolder' => trans('messages.last_name')
								 )
							)!!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.gender') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::select('gender',
							array('' => trans('messages.select_gender')
									, 'Male' => trans('messages.male')
									, 'Female' => trans('messages.female')),null,
							array('class' => 'form-control'
									, 'ng-model' => 'student.record.gender'
									, 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
								 )
							)!!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<input type="hidden" id="birth_date" ng-init="student.setDropDown()" />
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.city') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('city','',
							array('class' => 'form-control'
									, 'ng-model' => 'student.record.city'
									, 'ng-class' => "{ 'required-field' : student.fields['city'] }"
									, 'placeHolder' => trans('messages.city')
								 )
							)!!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.state') !!}</label>
					<div class="col-xs-5">
						{!! Form::text('state','',
							array('class' => 'form-control'
									, 'ng-model' => 'student.record.state'
									, 'ng-class' => "{ 'required-field' : student.fields['state'] }"
									, 'placeHolder' => trans('messages.state')
								 )
							)!!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="getCountries()">
						<select name="country_id" id="country" class="form-control" ng-class="{ 'required-field' : student.fields['country_id']}" ng-model="student.record.country_id" ng-change="student.getGradeLevel()">
							<option value="">{!! trans('messages.select_country') !!}</option>
							<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">{!! trans('messages.school_info') !!}</legend>
				<div class="form-group" ng-init="student.getGrades()">
					<label class="control-label col-xs-3">{!! trans_choice('messages.grade', 1) !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<select name="grade_code" ng-disabled="!student.record.country_id" class="form-control" ng-class="{ 'required-field' : student.fields['grade_code']}" ng-model="student.record.grade_code">
							<option value="">{!! trans('messages.select_level') !!}</option>
							<option ng-repeat="grade in student.grades" ng-value="grade.code">{! grade.name !}</option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<div class="col-xs-9 col-xs-offset-1 btn-container">
						{!! Form::button(trans('messages.save')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.save()'
							)
						) !!}
						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'student.setActive()'
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>