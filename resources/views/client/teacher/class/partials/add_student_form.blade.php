<div ng-if="class.active_add_student">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="class.errors || class.success">
		<div class="alert alert-error" ng-if="class.errors">
            <p ng-repeat="error in class.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="class.success">
            <p>{! class.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 module-container">
		<div class="col-xs-4 col-xs-offset-3">
			{!! Form::radio('add'
				, '1'
				, true
				, array(
					'id' => 'existing_student'
					, 'ng-model' => 'class.add_existing_student'
					, 'ng-click' => 'class.display()'
				)
			) !!}
			<span class="lbl padding-8" for="existing_student">Existing Student</span>
		</div>

		<div class="col-xs-3">
			{!! Form::radio('add'
				, '0'
				, false
				, array(
					  'id' => 'new_student'
					, 'ng-model' => 'class.add_existing_student'
					, 'ng-click' => 'class.display()'
				)	
			) !!}
			<span class="lbl padding-8" for="new_student">New Student</span>
		</div>
	</div>

	<div class="col-xs-12 module-container" ng-if="class.add_existing_student">
		{!! Form::open(
			[
				'id' => 'add_existing_student',
				'class' => 'form-horizontal'
			]
		) !!}
		
		<div class="form-group">
				<div class="col-xs-2">
					<label class="control-label">Email Address </label>
				</div>
				<div class="col-xs-5">
					{!! Form::text('email', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'class.record.email'
							, 'placeholder' => 'Email Address'
							, 'autocomplete' => 'off'
						)
					) !!}
				</div>
		</div>
		<div class="btn-container col-xs-5 col-xs-offset-2">
			{!! Form::button('Add'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-click' => 'class.addExistingStudent()'
				)
			) !!}

			{!! Form::button('Cancel'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => "class.setActive('view', class.record.id)"
				)
			) !!}
		</div>
		{!! Form::close() !!}
	</div>

	<div class="col-xs-12" ng-if="!class.add_existing_student">
		{!! Form::open(
			[
				'id' => 'add_new_student',
				'class' => 'form-horizontal'
			]
		) !!}
		
		<fieldset>
            <legend>User Credentials</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Username <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('username', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'Username' 
                            , 'ng-model' => 'class.add.username'
                            , 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
                            , 'ng-class' => "{ 'required-field' : class.fields['username'] }"
                            , 'ng-change' => "class.validateUsername()"
                        )
                    ) !!}
                </div>
                <div class="margin-top-8"> 
                    <i ng-if="class.validation.u_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="class.validation.u_success" class="fa fa-check success-color"></i>
                    <span ng-if="class.validation.u_error" class="error-msg-con">{! class.validation.u_error !}</span>
                </div>
            </div> 
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Email <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('email', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'Email Address' 
                            , 'ng-model' => 'class.add.email'
                            , 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
                            , 'ng-class' => "{ 'required-field' : class.fields['email'] }"
                            , 'ng-change' => "class.validateEmail()"
                        )
                    ) !!}
                </div>
                <div style="margin-top: 7px;">
                    <i ng-if="class.validation.e_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="class.validation.e_success" class="fa fa-check success-color"></i>
                    <span ng-if="class.validation.e_error" class="error-msg-con">{! class.validation.e_error !}</span>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Personal Information</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">First Name <span ng-class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('first_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : class.fields['first_name'] }"
                            , 'placeholder' => 'First Name' 
                            , 'ng-model' => 'class.add.first_name')
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Last Name <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('last_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : class.fields['last_name'] }"
                            , 'placeholder' => 'Last Name' 
                            , 'ng-model' => 'class.add.last_name')
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Gender <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::select('gender'
                        , array(
                            '' => '-- Select Gender --'
                            , 'male' => 'Male'
                            , 'female' => 'Female')
                        , ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : class.fields['gender'] }"
                            , 'ng-model' => 'class.add.gender'
                        )
                    ); !!}
                </div>
            </div>  
            <div class="form-group">
                <label for="" class="col-md-3 control-label">Birthday <span class="required">*</span></label>
                <div class="col-md-4">
                    <div class="dropdown">
                      <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                        <div class="input-group">
                            <input readonly="readonly" type="text" ng-class="{ 'required-field' : class.fields['birth_date'] }" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! class.add.birth | date:'dd/MM/yy' !}">
                            <input type="hidden" name="hidden_date" value="{! class.add.birth | date:'yyyyMMdd' !}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                      </a>
                      <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <datetimepicker data-ng-model="class.add.birth" data-ng-change="class.updateBirthday()" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                      </ul>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <label for="" class="col-md-3 control-label">City <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('city', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'City' 
                            , 'ng-class' => "{ 'required-field' : class.fields['city'] }"
                            , 'ng-model' => 'class.add.city'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">State <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('state', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'State' 
                            , 'ng-class' => "{ 'required-field' : class.fields['state'] }"
                            , 'ng-model' => 'class.add.state'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group" ng-init="getCountries()">
                <label for="" class="col-md-3 control-label">Country <span class="required">*</span></label>
                <div class="col-md-4">
                    <select name="country" class="form-control" ng-class="{ 'required-field' : class.fields['country'] }" ng-model="class.add.country" ng-change="getGrades(reg.country)">
                        <option value="">-- Select Country --</option>
                        <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>School Information</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">School Name <span class="required">*</span></label>
                <div class="col-md-4">
                    {!! Form::text('school_code', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-disabled'=>'true'
                            , 'ng-model' => 'class.add.school_code'
                            , 'ng-class' => "{ 'required-field' : class.fields['school_code'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group" ng-init="getGradeLevel()">
                <label for="" class="col-md-3 control-label">School level <span class="required">*</span></label>

                <div class="col-md-4 nullable">
                    <select name="grade_code" class="form-control" ng-disabled="true" ng-class="{ 'required-field' : class.fields['grade_code'] }" ng-model="class.add.grade_codse">
                        <option value="">-- Select Level --</option>
                        <option ng-selected="class.add.grade_code == grade.code" ng-repeat="grade in grades" value="{! grade.code !}">{! grade.name !}</option>
                    </select>
                </div>
            </div>    
        </fieldset> 
        <fieldset>
			<div class="btn-container col-xs-6 col-xs-offset-2">
				{!! Form::button('Add'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => 'class.addNewStudent()'
					)
				) !!}

				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "class.setActive('view', class.record.id)"
					)
				) !!}
			</div>
		 </fieldset> 
		{!! Form::close() !!}
	</div>
</div>