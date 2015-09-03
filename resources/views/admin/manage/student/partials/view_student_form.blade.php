<div ng-if="student.active_view || student.active_edit">
    <div class="content-title">
        <div class="title-main-content">
            <span ng-if="student.active_view">View Student Details</span>
            <span ng-if="student.active_edit">Edit Student Details</span>
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

	{!! Form::open(array('id'=> 'view_student_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12">
        <fieldset>
    		<legend class="legend-name-mid">
    			User Credentials
    		</legend>
    		<div class="form-group">
        		<label class="control-label col-xs-3">Username <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('username',''
        				, array(
        					'placeHolder' => 'Username'
        					, 'ng-disabled' => 'student.active_view'
        					, 'ng-model' => 'student.record.username'
        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'ng-change' => 'student.checkUsernameAvailability(student.record.username)'
                            , 'ng-class' => "{ 'required-field' : student.fields['username'] }"
        					, 'autocomplete' => 'off'
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
        					, 'ng-disabled' => 'student.active_view'
        					, 'ng-model' => 'student.record.email'
                            , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                            , 'ng-change' => 'student.checkEmailAvailability(student.record.email)'
                            , 'ng-class' => "{ 'required-field' : student.fields['email'] }"
                            , 'autocomplete' => 'off'
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
            <div class="form-group" ng-if="student.record.new_email">
                <label class="col-xs-3 control-label text-red" id="email">Pending Email <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('email',''
                        , array(
                            'placeHolder' => 'Email'
                            , 'ng-disabled' => 'true'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend class="legend-name-mid">
                Quick Stats
            </legend>
            <div class="form-group">
                <label class="control-label col-xs-3">Points</label>
                <div class="col-xs-5">
                    {!! Form::text('points',''
                        , array(
                            'placeHolder' => 'Points'
                            , 'ng-disabled' => 'true'
                            , 'ng-model' => 'student.record.points'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Badges</label>
                <div class="col-xs-5">
                    {!! Form::text('badges',''
                        , array(
                            'placeHolder' => 'Badges'
                            , 'ng-disabled' => 'true'
                            , 'ng-model' => 'student.record.badges'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3"></div>
                <div class="col-xs-5">
                    {!! Form::button('Edit Reward'
                        , array(
                            'class' => 'btn btn-blue'
                            , 'ng-click' => "student.setActive('reward', student.record.id)"
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
        		<label class="control-label col-xs-3">First Name <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('first_name','',
        				array('class' => 'form-control'
        						, 'ng-disabled' => 'student.active_view'
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
        						, 'ng-disabled' => 'student.active_view'
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
        						, 'Female' => 'Female'),'',
        				array('class' => 'form-control'
        						, 'ng-disabled' => 'student.active_view'
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
								<input readonly="readonly" type="text" name="birth_date" ng-class="{ 'required-field' : student.fields['birth_date'] }" placeholder="DD/MM/YY" class="form-control" value="{! student.record.birth | date:'dd/MM/yy' !}">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel" ng-if="student.active_edit">
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
                                , 'ng-disabled' => 'student.active_view'
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
                                , 'ng-disabled' => 'student.active_view'
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
                    <select name="country_id" 
                            id="country" 
                            class="form-control" 
                            ng-model="student.record.country_id" 
                            ng-change="student.getGradeLevel()"
                            ng-disabled="student.active_view"
                            ng-class="{ 'required-field' : student.fields['country_id'] }">
                        <option ng-selected="student.record.country_id == futureed.FALSE" value="">-- Select Country --</option>
                        <option ng-selected="student.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
        	<legend class="legend-name-mid">School Information</legend>
        	<div class="form-group">
        		<label class="control-label col-xs-3">School Name <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => 'School Name'
        						, 'ng-disabled' => 'student.active_view'
	        					, 'id' => 'school_code'
	        					, 'ng-model' => 'student.record.school_name'
	        					, 'ng-change' => "student.searchSchool()"
                        		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                , 'ng-class' => "{ 'required-field' : student.fields['school_code'] || student.fields['school_name'] }"
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
        		<label class="control-label col-xs-3">Grade <span class="required">*</span></label>
        		<div class="col-xs-5">
                    <select ng-disabled="student.active_view || !student.record.country_id" name="grade_code" ng-class="{ 'required-field' : student.fields['grade_code'] }" class="form-control" ng-model="student.record.grade_code">
                        <option value="">-- Select Level --</option>
                        <option ng-repeat="grade in student.grades" ng-selected="student.record.grade_code == grade.code" ng-value="grade.code">{! grade.name !}</option>
                    </select><br><br>
                </div>
        	</div>
        	<div class="col-xs-9 col-xs-offset-1">
        		<div class="btn-container" ng-if="student.active_view">
            		{!! Form::button('Edit'
    					, array(
    						'class' => 'btn btn-blue btn-medium'
    						, 'ng-click' => "student.setActive(futureed.ACTIVE_EDIT, student.record.id)"
    					)
    				) !!}

                    {!! Form::button('Cancel'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => "student.setActive()"
                        )
                    ) !!}
                </div>

                <div class="btn-container" ng-if="student.active_edit">
    				{!! Form::button('Save'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => "student.saveEdit()"
                        )
                    ) !!}

                    {!! Form::button('Cancel'
    					, array(
    						'class' => 'btn btn-gold btn-medium'
    						, 'ng-click' => "student.setActive(futureed.ACTIVE_VIEW, student.record.id)"
    					)
    				) !!}
        	</div>
        	</div>
        </fieldset>
	</div>
    <div class="col-xs-12 table-container">
        <div class="list-container" ng-cloak>
            <div class="title-mid">
                Module List
            </div>

            <div class="size-container">
                {!! Form::select('size'
                    , array(
                          '10' => '10'
                        , '20' => '20'
                        , '50' => '50'
                        , '100' => '100'
                    )
                    , '10'
                    , array(
                        'ng-model' => 'student.table.size'
                        , 'ng-change' => 'student.paginateBySize()'
                        , 'ng-if' => "student.modules.length"
                        , 'class' => 'form-control paginate-size pull-right'
                    )
                ) !!}
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Modules</th>
                        <th>Age Group</th>
                        <th ng-if="student.modules.length">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <tr ng-repeat="module in student.modules">
                    <td>{! module.name !}</td>
                    <td>{! module.grade.country_grade.age_group.age !}</td>
                    <td ng-if="student.records.length">
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="" ng-click="student.resetModule(module.student_module_id, student.record.id)" title="refresh"><span><i class="fa fa-refresh"></i></span></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="odd" ng-if="!student.modules.length && !student.table.loading">
                    <td valign="top" colspan="7">
                        No records found
                    </td>
                </tr>
                <tr class="odd" ng-if="student.table.loading">
                    <td valign="top" colspan="7">
                        Loading...
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="pull-right" ng-if="student.modules.length">
                <pagination 
                    total-items="student.table.total_items" 
                    ng-model="student.table.page"
                    max-size="student.table.paging_size"
                    items-per-page="student.table.size" 
                    previous-text = "&lt;"
                    next-text="&gt;"
                    class="pagination" 
                    boundary-links="true"
                    ng-change="student.paginateByPage()">
                </pagination>
            </div>
        </div>
    </div>
</div>