{!! Form::open(array('id' => 'profile_form', 'class' => 'form-horizontal', 'ng-if' => 'profile.active_index || profile.active_edit')) !!}
	<div class="alert alert-success" ng-if="profile.success">
        <p>You have successfully updated your profile.</p>
    </div>
    
    <fieldset>
		<legend>Credentials Information</legend>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">Username <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('username', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Username' 
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.username'
                        , 'ng-model-options' => "{debounce : {'default' : 1000} }"
                        , 'ng-change' => "checkAvailability(prof.username, 'Student')")
                ) !!}
            </div>
            <div style="margin-top: 7px;"> 
                <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                <i ng-if="u_success" class="fa fa-check success-color"></i>
                <span ng-if="u_error" class="alert alert-error">{! u_error !}</span>
            </div>
        </div>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">Email <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Email Address' 
                        , 'ng-disabled' => 'true' 
                        , 'ng-model' => 'profile.prof.email'
                    )
                ) !!}
            </div>
            <div class="col-xs-2">
            	<a href="{!! route('student.profile.edit_email')!!}" class="edit-email">Edit</a>
            </div>	
            <div class="col-xs-5 alert-message">
                <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                <i ng-if="e_success" class="fa fa-check success-color"></i>
                <span ng-if="e_error" class="alert alert-error">{! e_error !}</span>
            </div>
        </div>
        <div class="form-group" ng-if="confirm_email">
            <label for="" class="col-md-2 control-label">Pending Email <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Pending Email Address' 
                        , 'ng-disabled' => 'true' 
                        , 'ng-model' => 'profile.prof.new_email'
                    )
                ) !!}
            </div>
            <div class="col-xs-2">
            	<a href="{!! route('student.profile.edit_email') !!}" class="edit-email">Confirm</a>
            </div>	
            <div class="col-xs-5 alert-message">
                <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                <i ng-if="e_success" class="fa fa-check success-color"></i>
                <span ng-if="e_error" class="alert alert-error">{! e_error !}</span>
            </div>
        </div>
	</fieldset>					
	<fieldset>
		<legend>Personal Information</legend>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">First Name <span class="required">*</span></label>
            <div class="col-md-5">
                {!! Form::text('first_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'First Name'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.first_name')
                ) !!}
            </div>
        </div>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">Last Name <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('last_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Last Name'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.last_name')
                ) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">Gender <span class="required">*</span></label>
            <div class="col-md-5">
                {!! Form::select(''
                	, array(
                		'' => '-- Select Gender --'
                		, 'Male' => 'Male'
                		, 'Female' => 'Female'
                	)
                	, 'prof.gender'
                	, array(
                		'class' => 'form-control'
                		, 'ng-model' => 'profile.prof.gender'
                		, 'ng-disabled' => '!profile.active_edit')
                ) !!}
            </div>
        </div>  
        <div class="form-group">
            <label for="" class="col-xs-2 control-label">Birthday <span class="required">*</span></label>
            <div class="col-xs-5">
                <div class="dropdown">
                  <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                    <div class="input-group">
                        <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! profile.prof.birth | date:'dd/MM/yy' !}">
                        <input type="hidden" name="hidden_date" value="{! profile.prof.birth | date:'yyyyMMdd' !}">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                  </a>
                  <ul ng-show="profile.active_edit" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <datetimepicker data-ng-model="profile.prof.birth" ng-change="updateAge()" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                  </ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">Age</label>
            <div class="col-md-5">
            	{!! Form::text('age', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => 'true'
                        , 'placeholder' => 'Age' 
                        , 'ng-model' => 'profile.prof.age')
                ) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">City <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('city', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'City' 
                        , 'ng-model' => 'profile.prof.city')
                ) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('state', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'State' 
                        , 'ng-model' => 'profile.prof.state')
                ) !!}
            </div>
        </div>
        <div class="form-group" ng-init="getCountries()">
            <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
            <div class="col-md-5">
                <select class="form-control" name="country" ng-model="profile.prof.country" ng-disabled="!profile.active_edit">
                    <option selected="selected" value="">-- Select Country --</option>
                    <option ng-repeat="country in countries" value="{! country.id !}" 
                    	ng-selected="{! profile.prof.country == country.id !}">{! country.name !}</option>
                </select>
            </div>
        </div>
	</fieldset>					
	<fieldset>
		<legend>School Information</legend>
		<div class="form-group" ng-if="prof.school_name">
            <label for="" class="col-md-2 control-label">School Name</label>
            <div class="col-md-5">
            	{!! Form::text('school_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'School Name' 
                        , 'ng-model' => 'prof.school_name')
                ) !!}
            </div>
        </div>
		<div class="form-group" ng-init="getGradeLevel()">
        <label for="" class="col-xs-2 control-label">School level <span class="required">*</span></label>

        <div class="col-md-5 nullable">
            <select class="form-control" name="grade_code" ng-model="profile.prof.grade_code" ng-disabled="!profile.active_edit">
                <option value="">-- Select Level --</option>
                <option ng-selected="{! profile.prof.grade_code == grade.code !}" ng-repeat="grade in grades" value="{! grade.code !}">{! grade.name !}</option>
            </select>
        </div><br><br>
    </div>   
	</fieldset>
	<div class="form-group">
		<div class="btn-container">
			<div class="col-xs-9" ng-if="!profile.active_edit">
				{!! Form::button('Change Picture Password'
					, array(
						'class' => 'btn btn-maroon btn-medium'
                        , 'ng-click' => "profile.setStudentProfileActive('password')"
					)
				) !!}

				{!! Form::button('Edit Profile'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('edit')"
					)
				) !!}
			</div>

			<div class="col-xs-9" ng-if="profile.active_edit">
				{!! Form::button('Save Changes'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.saveProfile()'
					)
				) !!}

				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('index')"
					)
				) !!}
			</div>
		</div>
	</div>
{!! Form::close() !!}