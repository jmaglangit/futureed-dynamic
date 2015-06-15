@extends('client.app')

@section('content')
<div class="container" ng-controller="LoginController as register" ng-cloak>
    <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

    <div class="form-style form-wide">
        <div class="row">
            <div class="col-md-12 register_users">
                <div class="col-md-4 col-md-offset-4">
                    {!! Html::image('/images/user_teacher.png', 'Teacher'
                        , array(
                            'id' => 'user_teacher'
                        )
                    ) !!}
                <h4>Teacher</h4>
                </div>
            </div>

            <div class="col-md-12">
                <div class="alert alert-error" ng-if="errors">
                    <p ng-repeat="error in errors"> 
                        {! error !}
                    </p>
                </div>

            {!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal', 'ng-init' => 'register.getTeacherDetails()')) !!}
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('email', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Email Address'
                                    , 'ng-model' => 'register.reg.email'
                                    , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                    , 'ng-change' => "checkEmailAvailability(register.reg.email, 'Client')"
                                )
                            ) !!}

                            <div>
                                <span ng-if="e_error" class="error-msg-con">{! e_error !}</span>
                                <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                                <span ng-if="e_success" class="error-msg-con success-color">Email address is available.</span>
                            </div>
                        </div>

                        <label class="col-md-2 control-label">Username<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::text('username', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Username'
                                    , 'ng-model' => 'register.reg.username'
                                    , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                    , 'ng-change' => "checkAvailability(register.reg.username, 'Client')"
                                )
                            ) !!}

                            <div> 
                                <span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
                                <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                                <span ng-if="u_success" class="error-msg-con success-color">Username is available.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Password<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::password('password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Password'
                                    , 'ng-model' => 'register.reg.password'
                                )
                            ) !!}
                        </div>
                        <label class="col-md-2 control-label">Confirm Password<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::password('confirm_password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Confirm Password'
                                    , 'ng-model' => 'register.reg.confirm_password'
                                )
                            ) !!}
                        </div>
                    </div>   
                </fieldset>

            <fieldset>
            <legend>Personal Information</legend>
            <div class="form-group">
            <label class="col-md-2 control-label">First Name<span class="required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('first_name', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'First Name'
            , 'ng-model' => 'register.reg.first_name'
            )
            ) !!}
            </div>
            <label class="col-md-2 control-label">Last Name<span class="required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('last_name', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Last Name'
            , 'ng-model' => 'register.reg.last_name'
            )
            ) !!}
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-2 control-label">Street Address<span class="required" ng-if="register.required">*</span></label>
            <div class="col-md-6">
            {!! Form::text('street_address', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Street Address'
            , 'ng-model' => 'register.reg.street_address'
            )
            ) !!}
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-2 control-label">City<span class="required" ng-if="register.required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('city', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'City'
            , 'ng-model' => 'register.reg.city'
            )
            ) !!}
            </div>
            <label class="col-md-2 control-label">State<span class="required" ng-if="register.required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('state', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'State'
            , 'ng-model' => 'register.reg.state'
            )
            ) !!}
            </div>
            </div>   
            <div class="form-group">
            <label class="col-md-2 control-label">Zip Code<span class="required" ng-if="register.required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('zip', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Postal Code'
            , 'ng-model' => 'register.reg.zip'
            )
            ) !!}
            </div>
            <label class="col-md-2 control-label">Country<span class="required" ng-if="register.required">*</span></label>
            <div class="col-md-4" ng-init="getCountries()">
            <select  name="country" class="form-control" ng-model="register.reg.country">
            <option value="">-- Select Country --</option>
            <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
            </select>
            </div>
            </div>
            </fieldset>
            <div id="principal" ng-if="register.principal" class="role-div">
            <fieldset>
            <legend>School Information</legend>
            <div class="form-group">
            <label class="col-md-2 control-label">School Name<span class="required">*</span></label>
            <div class="col-md-6">
            {!! Form::text('school_name', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'School Name'
            , 'ng-model' => 'register.reg.school_name'
            )
            ) !!}
            </div>
            </div>
            <div class="form-group">
            <label class="col-md-2 control-label">School Address<span class="required">*</span></label>
            <div class="col-md-6">
            {!! Form::text('school_address', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'School Address'
            , 'ng-model' => 'register.reg.school_address'
            )
            ) !!}
            </div>
            </div>
            <div class="form-group">
            <label class="col-md-2 control-label">City</label>
            <div class="col-md-4">
            {!! Form::text('school_city', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'City'
            , 'ng-model' => 'register.reg.school_city'
            )
            ) !!}
            </div>
            <label class="col-md-2 control-label">State<span class="required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('school_state', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'State'
            , 'ng-model' => 'register.reg.school_state'
            )
            ) !!}
            </div>
            </div>   
            <div class="form-group">
            <label class="col-md-2 control-label">Zip Code<span class="required">*</span></label>
            <div class="col-md-4">
            {!! Form::text('school_zip', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Postal Code'
            , 'ng-model' => 'register.reg.school_zip'
            )
            ) !!}
            </div>
            <label class="col-md-2 control-label">Country<span class="required">*</span></label>
            <div class="col-md-4" ng-init="getCountries()">
            <select  name="school_country" class="form-control" ng-model="register.reg.school_country">
            <option value="">-- Select Country --</option>
            <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
            </select>
            </div>
            </div> 
            <legend>School Contact Information</legend>
            <div class="form-group">
            <label class="col-md-2 control-label">Contact Person<span class="required">*</span></label>
            <div class="col-md-6">
            {!! Form::text('contact_name', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Contact Person'
            , 'ng-model' => 'register.reg.contact_name'
            )
            ) !!}
            </div>
            </div>
            <div class="form-group">
            <label class="col-md-2 control-label">Contact Number<span class="required">*</span></label>
            <div class="col-md-6">
            {!! Form::text('contact_number', ''
            , array(
            'class' => 'form-control'
            , 'placeholder' => 'Contact Number'
            , 'ng-model' => 'register.reg.contact_number'
            )
            ) !!}
            </div>
            </div>
            </fieldset>
            </div>
            <div class="block_bottom">
            <fieldset>
            <div class="form-group">
            <div class="checkbox text-center">
            <label>
            <input type="checkbox" ng-model="register.term">
            I agree on the <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">Terms and Conditions</a> and <a href="#" ng-click="showModal('policy_modal')">Data Privacy Policy</a>
            </label>
            </div>
            </div>
            <div class="btn-container col-sm-6 col-sm-offset-3">
            <a ng-click="register.registerClient()" type="button" class="btn btn-blue btn-medium">Register</a>
            <a href="{!! route('client.login') !!}" type="button" class="btn btn-gold btn-medium">Cancel</a>
            </div>
            </fieldset>
            </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div template-directive template-url="{!! route('client.partials.registration_success') !!}"></div>

    @include('student.login.terms-and-condition')
    @include('student.login.privacy-policy')

</div>
@endsection

@section('scripts')

{!! Html::script('/js/client/controllers/login_controller.js') !!}
{!! Html::script('/js/client/services/login_service.js') !!}
{!! Html::script('/js/client/services/profile_service.js') !!}
{!! Html::script('/js/client/login.js') !!}

@stop