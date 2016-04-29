<div ng-if="class.active_add_student">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_student') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="class.errors || class.success">
		<div class="alert alert-error" ng-if="class.errors">
            <p ng-repeat="error in class.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="class.success">
            <p>{! class.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
        <div class="col-xs-6  col-xs-offset-2"> 
            <label class="cursor-pointer">
            {!! Form::radio('status'
                , true
                , true
                , array(
                    'ng-model' => 'class.add_existing_student'
                    , 'ng-change' => 'class.clearData()'
                )
            ) !!}
            <span class="lbl padding-8">{!! trans('messages.new_student') !!}</span>
            </label>
        </div>
        <div>
            <label class="cursor-pointer">
            {!! Form::radio('status'
                , false
                , false
                , array(
                    'ng-model' => 'class.add_existing_student'
                    , 'ng-change' => 'class.clearData()'
                )
            ) !!}
            <span class="lbl padding-8">{!! trans('messages.existing_student') !!}</span>
            </label>
        </div>
	</div>

	<div class="col-xs-12" ng-if="!class.add_existing_student">
		{!! Form::open(
			[
				'id' => 'add_existing_student'
				, 'class' => 'form-horizontal'
                , 'ng-submit' => 'class.addExistingStudent($event)'
			]
		) !!}
            <fieldset>
                <legend>{!! trans('messages.user_credentials') !!}</legend>
                <div class="form-group">
                    <label for="" class="col-md-3 control-label">{!! trans('messages.email_address') !!} <span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('email', ''
                            , array(
                                'class' => 'form-control'
                                , 'ng-model' => 'class.add.email'
                                , 'placeholder' => trans('messages.email_address')
                                , 'ng-class' => "{ 'required-field' : class.fields['email'] }"
                                , 'autocomplete' => 'off'
                            )
                        ) !!}
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="btn-container col-xs-5 col-xs-offset-2">
                    {!! Form::button(trans('messages.add_student')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'class.addExistingStudent()'
                        )
                    ) !!}

                    {!! Form::button(trans('messages.cancel')
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => "class.setActive('view', class.record.id)"
                        )
                    ) !!}
                </div>
            </fieldset> 
		{!! Form::close() !!}
	</div>

	<div class="col-xs-12" ng-if="class.add_existing_student">
		{!! Form::open(
			[
				'id' => 'add_new_student',
				'class' => 'form-horizontal'
			]
		) !!}
		
		<fieldset>
            <legend>{!! trans('messages.user_credentials') !!}</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.username') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('username', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => trans('messages.username')
                            , 'ng-model' => 'class.add.username'
                            , 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
                            , 'ng-class' => "{ 'required-field' : class.fields['username'] }"
                            , 'ng-change' => "class.validateUsername()"
                            , 'autocomplete' => 'off'
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
                <label for="" class="col-md-3 control-label">{!! trans('messages.email_address') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('email', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => trans('messages.email_address')
                            , 'ng-model' => 'class.add.email'
                            , 'ng-model-options' => "{ debounce : { 'default' : 1000 } }"
                            , 'ng-class' => "{ 'required-field' : class.fields['email'] }"
                            , 'ng-change' => "class.validateEmail()"
                            , 'autocomplete' => 'off'
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
            <legend>{!! trans('messages.personal_info') !!}</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('first_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : class.fields['first_name'] }"
                            , 'placeholder' => trans('messages.first_name')
                            , 'ng-model' => 'class.add.first_name'
                            , 'autocomplete' => 'off'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('last_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : class.fields['last_name'] }"
                            , 'placeholder' => trans('messages.last_name')
                            , 'ng-model' => 'class.add.last_name'
                            , 'autocomplete' => 'off'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.gender') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::select('gender'
                        , array(
                            '' => trans('messages.select_gender')
                            , 'male' => trans('messages.male')
                            , 'female' => trans('messages.female'))
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
                <label class="col-md-3 control-label">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
                <div class="col-xs-6">
                    <input type="hidden" id="birth_date" ng-init="class.setDropdown()">
                </div>
            </div> 
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.city') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('city', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => trans('messages.city')
                            , 'ng-class' => "{ 'required-field' : class.fields['city'] }"
                            , 'ng-model' => 'class.add.city'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.state') !!}</label>
                <div class="col-md-5">
                    {!! Form::text('state', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => trans('messages.state')
                            , 'ng-class' => "{ 'required-field' : class.fields['state'] }"
                            , 'ng-model' => 'class.add.state'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group" ng-init="getCountries()">
                <label for="" class="col-md-3 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    <select name="country_id" class="form-control" ng-disabled="true" ng-class="{ 'required-field' : class.fields['country'] }" ng-model="class.add.country_id" ng-change="getGrades(reg.country_id">
                        <option ng-selected="class.add.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
                        <option ng-selected="class.add.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{!! trans('messages.school_info') !!}</legend>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('school_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-disabled'=>'true'
                            , 'ng-model' => 'class.add.school_name'
                            , 'ng-class' => "{ 'required-field' : class.fields['school_name'] || class.fields['school_code'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-3 control-label">{!! trans('messages.school_level') !!} <span class="required">*</span></label>

                <div class="col-md-5 nullable" ng-init="class.getGradeLevel(class.add.country_id)">
                    <select name="grade_code" class="form-control" ng-disabled="true" ng-class="{ 'required-field' : class.fields['grade_code'] }" ng-model="class.add.grade_codse">
                        <option value="">{!! trans('messages.select_level') !!}</option>
                        <option ng-selected="class.add.grade_code == grade.code" ng-repeat="grade in class.grades" ng-value="grade.code">{! grade.name !}</option>
                    </select>
                </div>
            </div>    
        </fieldset> 
        <fieldset>
			<div class="btn-container col-xs-6 col-xs-offset-2">
				{!! Form::button(trans('messages.add_student')
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => 'class.addNewStudent()'
					)
				) !!}

				{!! Form::button(trans('messages.cancel')
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