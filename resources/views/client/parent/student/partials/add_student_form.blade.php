<div ng-if="student.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
		</div>
	</div>

	<div class="container form-content">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
        <div class="alert alert-success" ng-if="student.success">
        	<p>Successfully added new student user.</p>
        </div>

        <div class="module-container" ng-init="student.existActive('new')">
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
		</div>

		{!! Form::open(['class' => 'form-horizontal', 'id' => 'add_student_form']) !!}
		<div class="form-content row">
			<div ng-if="student.exist">
				<fieldset>
					<legend class="legend">Login Credential</legend>

					<div class="form-group">
						<label class="control-label col-xs-3">Email <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('email_exist', '',
								[
									'class' => 'form-control',
									'ng-model' => 'student.reg.email_exist',
									'placeHolder' => 'Email'
								]
							) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-7 col-xs-offset-2 btn-container">
							{!! Form::button('Add Student'
								, array(
									'class' => 'btn btn-blue btn-medium bottom-5'
									, 'ng-click' => 'student.addExist()'
								)
							) !!}
							{!! Form::button('Cancel'
								, array(
									'class' => 'btn btn-gold btn-medium bottom-5'
									, 'ng-click' => "student.setActive('list')"
								)
							) !!}
						</div>
					</div>
				</fieldset>
			</div>
			
			<div ng-if="!student.exist">
				<fieldset>
					<legend class="legend">Login Credentials</legend>
					<div class="form-group">
						<label class="col-xs-3 control-label">Username <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('username', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.reg.username'
									, 'placeHolder' => 'Username'
									, 'ng-class' => "{ 'required-field' : student.fields['username'] }"
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
									, 'ng-change' => 'student.checkUsernameAvailability()'
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
									, 'ng-model' => 'student.reg.email'
									, 'ng-class' => "{ 'required-field' : student.fields['email'] }"
									, 'placeHolder' => 'Email'
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
									, 'ng-change' => 'student.checkEmailAvailability()'
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
									, 'ng-model' => 'student.reg.first_name'
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
									, 'ng-model' => 'student.reg.last_name'
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
								, 'ng-model' => 'student.reg.gender'
								, 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
								]) 
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Birthday <span class="required">*</span></label>
						<div class="col-xs-5">
	                        <div class="dropdown">
	                          	<a class="dropdown-toggle" id="dropdown3" role="button" data-toggle="dropdown" data-target="#" href="#">
	                                <div class="input-group">
	                                <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" ng-class="{ 'required-field' : student.fields['birth_date'] }" value="{! student.reg.birth | date:'dd/MM/yy' !}">
	                                    <input type="hidden" name="hidden_date" value="{! student.reg.birth | date:'yyyyMMdd' !}">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
	                            </a>
	                            <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
	                                <datetimepicker data-ng-model="student.reg.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown3', startView:'day', minView:'day' }"/>
	                            </ul>
	                        </div>
	                    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">City <span class="required">*</span></label>
						<div class="col-xs-5">
							{!! Form::text('city', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.reg.city'
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
									'ng-model' => 'student.reg.state',
									'placeHolder' => 'State'
								]
							) !!}
						</div>
					</div>
					<div class="form-group" ng-init="getCountries()">
						<label class="control-label col-xs-3">Country <span class="required">*</span></label>
						<div class="col-xs-5">
	                    	<select name="country_id" class="form-control" ng-model="student.reg.country_id" ng-class="{'required-field' : student.fields['country_id']}">
	                        	<option value="">-- Select Country --</option>
	                        	<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	                    	</select>
	                	</div>
					</div>
				</fieldset>
			
				<div class="col-xs-7 col-xs-offset-2 btn-container">
					{!! Form::button('Add Student'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'student.addStudent()'
						)
					) !!}
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "student.setActive('list')"
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>