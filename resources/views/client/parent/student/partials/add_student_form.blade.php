<div ng-if="student.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_student') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="student.success">
			<p> 
				{! student.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
        <fieldset ng-init="student.existActive('new')">
	        <div class="col-xs-6  col-xs-offset-2"> 
	            <label class="cursor-pointer">
	            {!! Form::radio('status'
	                , false
	                , false
	                , array(
	                    'ng-model' => 'student.exist'
	                    , 'ng-click' => 'student.existActive()'
	                )
	            ) !!}

	            <span class="lbl padding-8">{!! trans('messages.new_student') !!}</span>
	            </label>
	        </div>
	        <div>
	            <label class="cursor-pointer">
	            {!! Form::radio('status'
	                , true
	                , true
	                , array(
	                    'ng-model' => 'student.exist'
	                    , 'ng-click' => 'student.existActive()'
	                )
	            ) !!}

	            <span class="lbl padding-8">{!! trans('messages.existing_student') !!}</span>
	            </label>
	        </div>
		</fieldset>

		<div ng-if="student.exist">
			{!! Form::open(
				array(
					'class' => 'form-horizontal'
					, 'ng-submit' => 'student.addExist($event)'
				)
			) !!}
				<fieldset>
					<legend class="legend">{!! trans('messages.login_credentials') !!}</legend>

					<div class="form-group">
						<label class="control-label col-xs-3">{!! trans('messages.email') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('email_exist', '',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
									, 'ng-model' => 'student.record.email_exist'
									, 'autocomplete' => 'off'
									, 'placeHolder' => trans('messages.email')
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-7 col-xs-offset-2 btn-container">
							{!! Form::button(trans('messages.add_student')
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => 'student.addExist($event)'
								)
							) !!}
							{!! Form::button(trans('messages.cancel')
								, array(
									'class' => 'btn btn-gray btn-medium'
									, 'ng-click' => "student.setActive()"
								)
							) !!}
						</div>
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
		
		<div ng-if="!student.exist">
			{!! Form::open(
				array(
					'class' => 'form-horizontal'
					, 'ng-submit' => 'student.addStudent($event)'
					, 'id' => 'add_student_form'
				)
			) !!}
				<fieldset>
					<legend class="legend">{!! trans('messages.login_credentials') !!}</legend>
					<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.username') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('username', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.username'
									, 'placeHolder' => trans('messages.username')
									, 'ng-class' => "{ 'required-field' : student.fields['username'] }"
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
									, 'ng-change' => 'student.checkUsername(student.record.username, futureed.STUDENT, futureed.FALSE)'
								]
							) !!}
						</div>
						<div class="margin-top-8"> 
			                <i ng-if="student.validation.u_loading" class="fa fa-spinner fa-spin"></i>
			                <i ng-if="student.validation.u_success" class="fa fa-check success-color"></i>
			                <span ng-if="student.validation.u_error" class="error-msg-con">{! student.validation.u_error !}</span>
			            </div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.email') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('email', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.email'
									, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
									, 'placeHolder' => trans('messages.email')
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
									, 'ng-change' => 'student.checkEmail(student.record.email, futureed.STUDENT, futureed.FALSE)'
								]
							) !!}
						</div>
						<div class="margin-top-8"> 
			                <i ng-if="student.validation.e_loading" class="fa fa-spinner fa-spin"></i>
			                <i ng-if="student.validation.e_success" class="fa fa-check success-color"></i>
			                <span ng-if="student.validation.e_error" class="error-msg-con">{! student.validation.e_error !}</span>
			            </div>	
					</div>
				</fieldset>

				<fieldset>
					<legend class="legend">{!! trans('messages.personal_info') !!}</legend>
					<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('first_name', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.first_name'
									, 'ng-class' => "{ 'required-field' : student.fields['first_name'] }"
									, 'placeHolder' => trans('messages.first_name')
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('last_name', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.last_name'
									, 'ng-class' => "{ 'required-field' : student.fields['last_name'] }"
									, 'placeHolder' => trans('messages.last_name')
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.gender') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::select('gender',
								['' => trans('messages.select_gender'),
								'Male'=> trans('messages.male'),
								'Female' => trans('messages.female')]
								,null,
								['class' => 'form-control'
								, 'ng-model' => 'student.record.gender'
								, 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
								]) 
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
						<div class="col-xs-6">
	                        <input type="hidden" id="birth_date">
	                    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">{!! trans('messages.city') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('city', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.city'
									, 'ng-class' => "{'required-field' : student.fields['city']}"
									, 'placeHolder' => trans('messages.city')
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">{!! trans('messages.state') !!}</label>
						<div class="col-xs-5">
							{!! Form::text('state', '',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.state',
									'placeHolder' => trans('messages.state')
								]
							) !!}
						</div>
					</div>
					<div class="form-group" ng-init="getCountries()">
						<label class="control-label col-xs-3">{!! trans('messages.country') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
	                    	<select name="country_id" class="form-control" ng-model="student.record.country_id" ng-class="{'required-field' : student.fields['country_id']}">
	                        	<option value="">{!! trans('messages.select_country') !!}</option>
	                        	<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	                    	</select>
	                	</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="col-xs-8 col-xs-offset-1 btn-container">
						{!! Form::button(trans('messages.add_student')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.addStudent($event)'
							)
						) !!}
						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gray btn-medium'
								, 'ng-click' => "student.setActive()"
							)
						) !!}
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</div>