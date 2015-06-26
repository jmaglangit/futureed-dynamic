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
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'add_student_form']) !!}
		<div class="col-xs-10 col-xs-offset-1 margin-top-60">
			<div class="form-group" ng-init="student.existActive('old')">
				<div class="col-xs-3">
					{!! Form::radio('status'
						,'exist'
						, true
						, array(
							'ng-model' => 'student.is_exist',
							'ng-click' => "student.existActive('old')"
							)
						) !!}
					<span class="lbl padding-8">Existing Student</span>
				</div>
				<label class="control-label col-xs-2">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email_exist', '',
						[
							'class' => 'form-control',
							'ng-model' => 'student.reg.email_exist',
							'placeHolder' => 'Email',
							'ng-disabled' => 'student.exist'
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-6 col-xs-offset-3 btn-container">
					{!! Form::button('Add'
						, array(
							'class' => 'btn btn-blue btn-medium bottom-5'
							, 'ng-disabled' => 'student.exist'
							, 'ng-click' => 'student.addExist()'
						)
					) !!}
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium bottom-5'
							, 'ng-disabled' => 'student.exist'
							, 'ng-click' => "student.setActive('list')"
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-3">
					{!! Form::radio('status'
						,'not-exist'
						, false
						, array(
							'ng-model' => 'student.is_exist',
							'ng-click' => "student.existActive('new')"
							)
						) !!}
					<span class="lbl padding-8">New Student</span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-10 col-xs-offset-1">
					<fieldset>
						<legend class="legend-name-mid">Login Credentials</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Username <span class="required">*</span></label>
							<div class="col-xs-5">
								{!! Form::text('username', '',
									[
										'class' => 'form-control'
										, 'ng-model' => 'student.reg.username'
										, 'placeHolder' => 'Username'
										, 'ng-disabled' => '!student.exist'
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
							<label class="col-xs-2 control-label">Email <span class="required">*</span></label>
							<div class="col-xs-5">
								{!! Form::text('email', '',
									[
										'class' => 'form-control'
										, 'ng-model' => 'student.reg.email'
										, 'placeHolder' => 'Email'
										, 'ng-disabled' => '!student.exist'
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
						<legend class="legend-name-mid">Personal Information</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Firstname <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('first_name', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.reg.first_name',
										'placeHolder' => 'Firstname',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
							<label class="col-xs-2 control-label">Lastname <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('last_name', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.reg.last_name',
										'placeHolder' => 'Lastname',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-2 control-label">Gender <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::select('gender',
									['' => '-- Select Gender --',
									'Male'=> 'Male', 
									'Female' => 'Female']
									,null,
									['class' => 'form-control', 
									'ng-model' => 'student.reg.gender',
									'ng-disabled' => '!student.exist']) 
								!!}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
							<div class="col-md-4">
	                            <div class="dropdown">
	                              	<a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
		                                <div class="input-group">
	                                    <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! student.reg.birth | date:'dd/MM/yy' !}">
		                                    <input type="hidden" name="hidden_date" value="{! student.reg.birth | date:'yyyyMMdd' !}">
		                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		                                </div>
		                            </a>
		                            <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
		                                <datetimepicker data-ng-model="student.reg.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
		                            </ul>
		                        </div>
		                    </div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2">City <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('city', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.reg.city',
										'placeHolder' => 'City',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2">State</label>
							<div class="col-xs-4">
								{!! Form::text('state', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.reg.state',
										'placeHolder' => 'State',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group" ng-init="getCountries()">
							<label class="control-label col-xs-2">Country <span class="required">*</span></label>
							<div class="col-md-4">
                            	<select ng-disabled="!student.exist" name="country_id" class="form-control" ng-model="student.reg.country_id">
                                	<option value="">-- Select Country --</option>
                                	<option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            	</select>
                        	</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="col-xs-6 col-xs-offset-3">
				<div class="btn-container">
						<div class="margin-40-bot">
							{!! Form::button('Add'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => 'student.addStudent()'
									, 'ng-disabled' => '!student.exist'
								)
							) !!}
							{!! Form::button('Cancel'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "student.setActive('list')"
									, 'ng-disabled' => '!student.exist'
								)
							) !!}
						</div>
					</div>
			</div>
		</div>
	</div>
</div>