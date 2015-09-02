{!! Form::open(array('id' => 'profile_form', 'class' => 'form-horizontal', 'ng-if' => 'profile.active_index || profile.active_edit')) !!}
	<div class="alert alert-success" ng-if="profile.success">
        <p>You have successfully updated your profile.</p>
    </div>
    
    <fieldset>
		<legend>Credentials Information</legend>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">Username <span class="required">*</span></label>
            <div class="col-md-4">
            	{!! Form::text('username', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Username' 
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
            <label for="" class="col-md-2 control-label">Email <span class="required">*</span></label>
            <div class="col-md-3">
                {!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Email Address' 
                        , 'readonly' => 'readonly'
                        , 'ng-model' => 'profile.prof.email'
                    )
                ) !!}
            </div>
            <div class="col-xs-1">
                <a href="" ng-click="profile.setStudentProfileActive('edit_email')" class="edit-email">Edit</a>
            </div>  
        </div>
        <div class="form-group" ng-if="profile.prof.new_email">
            <label for="" class="col-md-2 control-label">Pending Email <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Pending Email Address' 
                        , 'readonly' => 'readonly' 
                        , 'ng-model' => 'profile.prof.new_email'
                    )
                ) !!}
            </div>
            <div class="col-xs-3">
                <a href="" ng-click="profile.setStudentProfileActive('confirm_email')" class="edit-email">Confirm Email Address</a>
            </div>	
        </div>
	</fieldset>					
	<fieldset>
		<legend>Personal Information</legend>
		<div class="form-group">
            <label for="" class="col-md-2 control-label">First Name <span class="required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('first_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'First Name'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-class' => "{ 'required-field' : profile.fields['first_name']}"
                        , 'ng-model' => 'profile.prof.first_name')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">Last Name <span class="required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('last_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Last Name'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-class' => "{ 'required-field' : profile.fields['last_name']}"
                        , 'ng-model' => 'profile.prof.last_name')
                ) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-xs-2 control-label">Birthday <span class="required">*</span></label>
            <div class="col-xs-6">
                <input type="hidden" id="birth_date">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">Gender <span class="required">*</span></label>
            <div class="col-md-4">
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
                        , 'ng-class' => "{ 'required-field' : profile.fields['gender']}"
                		, 'ng-disabled' => '!profile.active_edit')
                ) !!}
            </div>
             <label for="" class="col-md-2 control-label">Age</label>
            <div class="col-md-4">
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
            <div class="col-md-4">
                {!! Form::text('city', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'City' 
                        , 'ng-class' => "{ 'required-field' : profile.fields['city']}"
                        , 'ng-model' => 'profile.prof.city')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">State</span></label>
            <div class="col-md-4">
                {!! Form::text('state', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'State' 
                        , 'ng-class' => "{ 'required-field' : profile.fields['state']}"
                        , 'ng-model' => 'profile.prof.state')
                ) !!}
            </div>
        </div>
        <div class="form-group" ng-init="getCountries()">
            <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
            <div class="col-md-4">
                <select class="form-control" name="country_id"
                    ng-model="profile.prof.country_id" 
                    ng-change="profile.setCountryGrade()" 
                    ng-disabled="!profile.active_edit"
                    ng-class="{ 'required-field' : profile.fields['country_id'] || profile.fields['country']}">
                    <option ng-selected="profile.prof.country_id == futureed.FALSE" value="">-- Select Country --</option>
                    <option ng-selected="profile.prof.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
                </select>
            </div>
        </div>
	</fieldset>					
	<fieldset>
		<legend>School Information</legend>
		<div class="form-group" ng-if="prof.school_name">
            <label for="" class="col-md-2 control-label">School Name</label>
            <div class="col-md-4">
            	{!! Form::text('school_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'ng-disabled' => '!profile.active_edit'
                        , 'placeholder' => 'School Name' 
                        , 'ng-class' => "{ 'required-field' : profile.fields['first_name']}"
                        , 'ng-model' => 'prof.school_name')
                ) !!}
            </div>
        </div>
		<div class="form-group">
        <label for="" class="col-xs-2 control-label">School level <span class="required">*</span></label>

        <div class="col-md-4 nullable">
            <select class="form-control" name="grade_code" 
                ng-model="profile.prof.grade_code" 
                ng-disabled="!profile.active_edit || profile.grades.length <= 0"
                ng-class="{ 'required-field' : profile.fields['grade_code']}">
                <option value="">-- Select Level --</option>
                <option ng-selected="profile.prof.grade_code == grade.code" ng-repeat="grade in profile.grades" ng-value="grade.code">{! grade.name !}</option>
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