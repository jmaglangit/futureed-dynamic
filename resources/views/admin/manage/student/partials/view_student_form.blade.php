<div ng-if="student.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Client</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'view_student_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="student.success">
        	<p>Successfully edited student.</p>
        </div>
        <fieldset>
        	<div class="col-xs-6 row">
        		<legend class="legend-name-mid">
        			User Credentials
        		</legend>
        		<div class="form-group">
	        		<label class="control-label col-xs-4">Username <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('username',''
	        				, array(
	        					'placeHolder' => 'Username'
	        					, 'ng-disabled' => '!student.edit'
	        					, 'ng-model' => 'student.detail.username'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'student.checkUsernameAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        			<div class="margin-top-8" style="float:left"> 
			                <i ng-if="student.validation.u_loading" class="fa fa-spinner fa-spin"></i>
			                <i ng-if="student.validation.u_success" class="error-msg-con success-color">{! student.validation.u_success !}</i>
			                <span ng-if="student.validation.u_error" class="error-msg-con">{! student.validation.u_error !}</span>
			            </div>
	        		</div>
        		</div>
		        <div class="form-group">
        			<label class="col-xs-4 control-label" id="email">Email <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model' => 'student.detail.email'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'student.checkEmailAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
        			<a href="#" style="float:left" class="top-10">Edit Email</a>
        		</div>
                <div class="form-group" ng-if="student.detail.new_email">
                    <label class="col-xs-4 control-label text-red" id="email">Pending Email <span class="required">*</span></label>
                    <div class="col-xs-6">
                        {!! Form::text('email',''
                            , array(
                                'placeHolder' => 'Email'
                                , 'ng-disabled' => 'true'
                                , 'class' => 'form-control'
                            )
                        ) !!}
                    </div>
                </div>
        	</div>
        	<div class="col-xs-6">
        		<legend class="legend-name-mid">
        			Quick Stats
        		</legend>
        		<div class="form-group">
        			<label class="control-label col-xs-4">Points</label>
	        		<div class="col-xs-6">
	        			{!! Form::text('points',''
	        				, array(
	        					'placeHolder' => 'Points'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model' => 'student.detail.points'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
        		</div>
        		<div class="form-group">
        			<label class="control-label col-xs-4">Badges</label>
        			<div class="col-xs-6">
        				{!! Form::text('badges',''
	        				, array(
	        					'placeHolder' => 'Badges'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model' => 'student.detail.badges'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
        			</div>
        		</div>
        		<div class="btn-container" ng-if="false">
        			{!! Form::button('Edit Reward'
					, array(
						'class' => 'btn btn-blue btn-medium pull-right'
						, 'ng-click' => 'student.save()'
					)
				) !!}
        		</div>
        	</div>
        </fieldset>
        <fieldset>
        	<legend class="legend-name-mid">
        		Personal Information
        	</legend>
        	<div class="form-group">
        		<label class="control-label col-xs-2">First Name <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::text('first_name','',
        				array('class' => 'form-control'
        						, 'ng-disabled' => '!student.edit'
        					 	, 'ng-model' => 'student.detail.first_name'
        					 	, 'placeHolder' => 'First Name'
        					 )
        				)!!}
        		</div>
        		<label class="control-label col-xs-2">City <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::text('city','',
        				array('class' => 'form-control'
        						, 'ng-disabled' => '!student.edit'
        					 	, 'ng-model' => 'student.detail.city'
        					 	, 'placeHolder' => 'City'
        					 )
        				)!!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Last Name <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::text('last_name','',
        				array('class' => 'form-control'
        						, 'ng-disabled' => '!student.edit'
        					 	, 'ng-model' => 'student.detail.last_name'
        					 	, 'placeHolder' => 'Last Name'
        					 )
        				)!!}
        		</div>
        		<label class="control-label col-xs-2">State</label>
        		<div class="col-xs-4">
        			{!! Form::text('state','',
        				array('class' => 'form-control'
        						, 'ng-disabled' => '!student.edit'
        					 	, 'ng-model' => 'student.detail.state'
        					 	, 'placeHolder' => 'State'
        					 )
        				)!!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Gender <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::select('gender',
        				array('' => '-- Select Gender --'
        						, 'Male' => 'Male'
        						, 'Female' => 'Female'),'',
        				array('class' => 'form-control'
        						, 'ng-disabled' => '!student.edit'
        					 	, 'ng-model' => 'student.detail.gender'
        					 )
        				)!!}
        		</div>
        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
				<div class="col-md-4" ng-init="getCountries()">
					<select ng-disabled="!student.edit" name="country_id" 
							id="country" 
							class="form-control" 
							ng-model="student.detail.country_id" 
							ng-change="student.getCountryId()">
                        <option value="">-- Select Country --</option>
                        <option ng-repeat="country in countries" ng-selected="student.detail.country_id == country.id" value="{! country.id !}">{! country.name!}</option>
                    </select>
				</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
				<div class="col-md-4">
					<div class="dropdown">
						<a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
							<div class="input-group">
								<input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! student.detail.birth_date | date:'dd/MM/yy' !}">
								<input type="hidden" name="hidden_date" value="{! student.detail.birth_date | date:'yyyyMMdd' !}">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel" ng-if="student.edit">
							<datetimepicker data-ng-model="student.detail.birth_date" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
						</ul>
					</div>
				</div>
        	</div>
        </fieldset>
        <fieldset>
        	<legend class="legend-name-mid">School Information</legend>
        	<div class="form-group">
        		<label class="control-label col-xs-2">School Name <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('school_code',''
	        				, array(
	        					'placeHolder' => 'School Name'
        						, 'ng-disabled' => '!student.edit'
	        					, 'id' => 'school_code'
	        					, 'ng-model' => 'student.detail.school'
	        					, 'ng-change' => "student.searchSchool('edit')"
                        		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
        			<div class="angucomplete-holder" ng-if="student.schools">
						<ul class="col-xs-5 angucomplete-dropdown">
							<li class="angucomplete-row" ng-repeat="school in student.schools" ng-click="student.selectSchool(school)">
								{! school.name !}
							</li>
						</ul>
					</div>
        		</div>
        		<div class="margin-top-8"> 
		                <i ng-if="student.validation.s_loading" class="fa fa-spinner fa-spin"></i>
		                <span ng-if="student.validation.s_error" class="error-msg-con">{! student.validation.s_error !}</span>
		            </div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Grade <span class="required">*</span></label>
        		<div class="col-xs-5">
                    <select ng-disabled="!student.edit" name="grade_code" class="form-control" ng-model="student.detail.grade_code">
                        <option value="">-- Select Level --</option>
                        <option ng-repeat="grade in student.grades" ng-selected="student.detail.grade_code == grade.code" value="{! grade.code !}">{! grade.name !}</option>
                    </select><br><br>
                </div>
        	</div>
        	<div class="col-xs-6 col-xs-offset-3">
        		<div class="btn-container">
        		{!! Form::button('Edit'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => '!student.edit'
						, 'ng-click' => "student.setActive('edit', student.detail.id)"
					)
				) !!}
				{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => 'student.edit'
						, 'ng-click' => "student.saveEdit()"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-if' => '!student.edit'
						, 'ng-click' => "student.setActive('list')"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-if' => 'student.edit'
						, 'ng-click' => "student.setActive('view', student.detail.id)"
					)
				) !!}
        	</div>
        	</div>
        </fieldset>
	</div>
</div>