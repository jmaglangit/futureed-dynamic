<div ng-if="student.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
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

	            <span class="lbl padding-8">New Student</span>
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

	            <span class="lbl padding-8">Existing Student</span>
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
					<legend class="legend">Login Credential</legend>

					<div class="form-group">
						<label class="control-label col-xs-3">Email <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('email_exist', '',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
									, 'ng-model' => 'student.record.email_exist'
									, 'autocomplete' => 'off'
									, 'placeHolder' => 'Email'
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-7 col-xs-offset-2 btn-container">
							{!! Form::button('Add Student'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => 'student.addExist($event)'
								)
							) !!}
							{!! Form::button('Cancel'
								, array(
									'class' => 'btn btn-gold btn-medium'
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
					<legend class="legend">Login Credentials</legend>
					<div class="form-group">
						<label class="col-xs-3 control-label">Username <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('username', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.username'
									, 'placeHolder' => 'Username'
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
						<label class="col-xs-3 control-label">Email <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('email', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.email'
									, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
									, 'placeHolder' => 'Email'
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
					<legend class="legend">Personal Information</legend>
					<div class="form-group">
						<label class="col-xs-3 control-label">First Name <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('first_name', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.first_name'
									, 'ng-class' => "{ 'required-field' : student.fields['first_name'] }"
									, 'placeHolder' => 'First Name'
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">Last Name <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('last_name', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.last_name'
									, 'ng-class' => "{ 'required-field' : student.fields['last_name'] }"
									, 'placeHolder' => 'Last Name'
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-3 control-label">Gender <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::select('gender',
								['' => '-- Select Gender --',
								'Male'=> 'Male', 
								'Female' => 'Female']
								,null,
								['class' => 'form-control'
								, 'ng-model' => 'student.record.gender'
								, 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
								]) 
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Birthday <span class="required">*</span></label>
						<div class="col-xs-6">
	                        <input type="hidden" id="birth_date">
	                    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">City <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('city', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.city'
									, 'ng-class' => "{'required-field' : student.fields['city']}"
									, 'placeHolder' => 'City'
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">State</label>
						<div class="col-xs-5">
							{!! Form::text('state', '',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.state',
									'placeHolder' => 'State'
								]
							) !!}
						</div>
					</div>
					<div class="form-group" ng-init="getCountries()">
						<label class="control-label col-xs-3">Country <span class="required">*</span></label>
						<div class="col-xs-5">
	                    	<select name="country_id" class="form-control" ng-model="student.record.country_id" ng-class="{'required-field' : student.fields['country_id']}">
	                        	<option value="">-- Select Country --</option>
	                        	<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	                    	</select>
	                	</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="col-xs-8 col-xs-offset-1 btn-container">
						{!! Form::button('Add Student'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.addStudent($event)'
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "student.setActive()"
							)
						) !!}
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</div>