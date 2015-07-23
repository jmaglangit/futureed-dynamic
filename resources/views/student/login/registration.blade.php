@extends('student.app')

@section('content')
<div class="container login student-fnt" ng-init="checkRegistration('{!! $id !!}', '{!! $registration_token !!}')">
    <div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

    <div class="form-style register_student form-wide" ng-init="success={!! $success !!}" ng-show="!success" ng-cloak> 
        {!! Form::open(array('id' => 'registration_form' , 'class' => 'form-horizontal simple-form')) !!}

            <div class="form-header">
                <div class="media">
                    <div class="media-left">
                        {!! Html::image('/images/user_student.png') !!}
                    </div>
                    <div class="media-body">
                        <h2 class="box-title"><span class="thin">Student</span> Registration</h2>
                        <div class="info-box rd col-md-6">
                            <h4>For Student below 13 years old</h4>
                            <p>Parents should be the one to register, please click {!! Html::link(route('client.registration'), 'here') !!} to register.</p>
                        </div>
                        <div style="margin: 7px 0px;">(<span class="required">*</span> ) Indicates a required field.</div>
                    </div>
                </div>
            </div>
            
            <div class="form-content col-md-12">
                <div class="alert alert-danger" ng-if="errors">
                  <p ng-repeat="error in errors" > 
                    {! error !}
                  </p>
                </div>
                
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Username<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('username', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Username' 
                                    , 'ng-model' => 'reg.username'
                                    , 'ng-model-options' => "{debounce : {'default' : 1000}}"
                                    , 'ng-change' => "checkAvailability(reg.username, 'Student')")
                            ) !!}
                        </div>
                        <div style="margin-top: 7px;"> 
                            <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                            <i ng-if="u_success" class="fa fa-check success-color"></i>
                            <span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('email', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Email Address' 
                                    , 'ng-model' => 'reg.email'
                                    , 'ng-model-options' => "{debounce : {'default' : 1000}}"
                                    , 'ng-change' => "checkEmailAvailability(reg.email, 'Student')")
                            ) !!}
                        </div>
                        <div style="margin-top: 7px;">
                            <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                            <i ng-if="e_success" class="fa fa-check success-color"></i>
                            <span ng-if="e_error" class="error-msg-con">{! e_error !}</span>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">First Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('first_name', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'First Name' 
                                    , 'ng-model' => 'reg.first_name')
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Last Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('last_name', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Last Name' 
                                    , 'ng-model' => 'reg.last_name')
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Gender<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::select('gender'
                                , array(
                                    '' => '-- Select Gender --'
                                    , 'Male' => 'Male'
                                    , 'Female' => 'Female')
                                , ''
                                , array(
                                    'class' => 'form-control'
                                    , 'ng-model' => 'reg.gender')
                            ); !!}
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Birthday<span class="required">*</span></label>
                        <div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! reg.birth | date:'dd/MM/yy' !}">
                                    <input type="hidden" name="hidden_date" value="{! reg.birth | date:'yyyyMMdd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="reg.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">City<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('city', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'City' 
                                    , 'ng-model' => 'reg.city')
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">State</label>
                        <div class="col-md-4">
                            {!! Form::text('state', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'State' 
                                    , 'ng-model' => 'reg.state')
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group" ng-init="getCountries()">
                        <label for="" class="col-md-2 control-label">Country<span class="required">*</span></label>
                        <div class="col-md-4">
                            <select name="country_id" id="country" class="form-control" ng-model="reg.country_id" ng-change="getGradeLevel(reg.country_id)">
                                <option ng-selected ="reg.country_id == futureed.FALSE" value="">-- Select Country --</option>
                                <option ng-selected ="reg.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name !}</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group" ng-if="invited">
                        <label for="" class="col-md-2 control-label">School Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('state', 'N/A'
                                , array(
                                    'class' => 'form-control'
                                    , 'disabled' => 'disabled'
                                    , 'ng-model' => 'reg.school_name')
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">School level<span class="required">*</span></label>
                        <div class="col-md-4">
                            <select name="grade_code" ng-disabled="!grades.length" class="form-control" ng-model="reg.grade_code">
                                <option value="">-- Select Level --</option>
                                <option ng-selected="reg.grade_code == grade.code" ng-repeat="grade in grades"  ng-value="grade.code">{! grade.name !}</option>
                            </select>
                        </div><br><br>
                    </div>    
                </fieldset> 
            </div>
            <div class="block_bottom">
                <fieldset>
                    <div class="form-group">
                        <div class="checkbox text-center">
                            <label>
                                {!! Form::checkbox('terms', 1, null, array('ng-model' => 'terms')) !!}
                                
                                I agree on the 

                                {!! Html::link('#', 'Terms and Conditions'
                                    , array(
                                        'ng-click' => "showModal('terms_modal')"
                                        , 'data-toggle' => 'modal'
                                    )
                                ) !!}

                                 and 

                                {!! Html::link('#', 'Data Privacy Policy'
                                    , array(
                                        'ng-click' => "showModal('policy_modal')"
                                        , 'data-toggle' => 'modal'
                                    )
                                ) !!}
                            </label>
                        </div>
                    </div>
                    <div class="btn-container col-sm-6 col-sm-offset-3">
                        {!! Form::button('Register'
                            , array(
                                'class' => 'btn btn-maroon btn-medium'
                                , 'ng-click' => "validateRegistration(reg, terms, 'add')"
                                , 'ng-show' => '!edit_registration'
                            )
                        ) !!}

                         {!! Form::button('Edit Registration'
                            , array(
                                'class' => 'btn btn-maroon btn-medium'
                                , 'ng-click' => "validateRegistration(reg, terms, 'edit')"
                                , 'ng-show' => 'edit_registration'
                            )
                        ) !!}

                        {!! Html::link(route('student.login'), 'Cancel'
                            , array(
                                'class' => 'btn btn-gold btn-medium'
                            )
                        )!!}
                    </div>
                </fieldset>
            </div>
        {!! Form::close() !!}
    </div>

    @include('student.login.registration-success')
    @include('student.login.terms-and-condition')
    @include('student.login.privacy-policy')
</div>
@stop

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop