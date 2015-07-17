<div ng-if="student.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_student_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="student.success">
        	<p>{! student.success !}</p>
        </div>

        <fieldset>
        	<legend class="legend-name-mid">
        		User Credentials
        	</legend>
        	<div class="form-group">
        		<label class="col-xs-3 control-label" id="username">Username <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('username',''
        				, array(
        					'placeHolder' => 'Username'
        					, 'ng-model' => 'student.record.username'
        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'ng-change' => 'student.checkUsernameAvailability(student.record.username)'
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
        		<label class="col-xs-3 control-label" id="email">Email <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('email',''
        				, array(
        					'placeHolder' => 'Email'
        					, 'ng-model' => 'student.record.email'
        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'ng-change' => 'student.checkEmailAvailability(student.record.email)'
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
        </fieldset>
        <fieldset>
        	<legend class="legend-name-mid">
        		Personal Information
        	</legend>

        	<div class="form-group">
        		<label class="control-label col-xs-3">First Name <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('first_name','',
        				array('class' => 'form-control'
        					 	, 'ng-model' => 'student.record.first_name'
                                , 'ng-class' => "{ 'required-field' : student.fields['first_name'] }"
        					 	, 'placeHolder' => 'First Name'
        					 )
        				)!!}
        		</div>
        	</div>

        	<div class="form-group">
        		<label class="control-label col-xs-3">Last Name <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('last_name','',
        				array('class' => 'form-control'
        					 	, 'ng-model' => 'student.record.last_name'
                                , 'ng-class' => "{ 'required-field' : student.fields['last_name'] }"
        					 	, 'placeHolder' => 'Last Name'
        					 )
        				)!!}
        		</div>
        	</div>

        	<div class="form-group">
        		<label class="control-label col-xs-3">Gender <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::select('gender',
        				array('' => '-- Select Gender --'
        						, 'Male' => 'Male'
        						, 'Female' => 'Female'),null,
        				array('class' => 'form-control'
        					 	, 'ng-model' => 'student.record.gender'
                                , 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
        					 )
        				)!!}
        		</div>
        	</div>

        	<div class="form-group">
        		<label class="control-label col-xs-3">Birthday <span class="required">*</span></label>
				<div class="col-xs-5">
					<div class="dropdown">
						<a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
							<div class="input-group">
								<input readonly="readonly" type="text" ng-class="{ 'required-field' : student.fields['birth_date']}" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! student.record.birth | date:'dd/MM/yy' !}">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
							<datetimepicker data-ng-model="student.record.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
						</ul>
					</div>
				</div>
        	</div>

            <div class="form-group">
                <label class="control-label col-xs-3">City <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('city','',
                        array('class' => 'form-control'
                                , 'ng-model' => 'student.record.city'
                                , 'ng-class' => "{ 'required-field' : student.fields['city'] }"
                                , 'placeHolder' => 'City'
                             )
                        )!!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3">State</label>
                <div class="col-xs-5">
                    {!! Form::text('state','',
                        array('class' => 'form-control'
                                , 'ng-model' => 'student.record.state'
                                , 'ng-class' => "{ 'required-field' : student.fields['state'] }"
                                , 'placeHolder' => 'State'
                             )
                        )!!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label">Country <span class="required">*</span></label>
                <div class="col-xs-5" ng-init="getCountries()">
                    <select name="country_id" id="country" class="form-control" ng-class="{ 'required-field' : student.fields['country_id']}" ng-model="student.record.country_id" ng-change="student.getGradeLevel()">
                        <option value="">-- Select Country --</option>
                        <option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
        	<legend class="legend-name-mid">School Information</legend>
        	<div class="form-group" ng-init="student.getGrades()">
        		<label class="control-label col-xs-3">Grade <span class="required">*</span></label>
        		<div class="col-xs-5">
                    <select name="grade_code" ng-disabled="!student.record.country_id" class="form-control" ng-class="{ 'required-field' : student.fields['grade_code']}" ng-model="student.record.grade_code">
                        <option value="">-- Select Level --</option>
                        <option ng-repeat="grade in student.grades" ng-value="grade.code">{! grade.name !}</option>
                    </select><br><br>
                </div>
        	</div>
        	<div class="col-xs-9 col-xs-offset-1 btn-container">
        		{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => 'student.save()'
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => 'student.setActive()'
					)
				) !!}
        	</div>
        </fieldset>
	</div>
</div>