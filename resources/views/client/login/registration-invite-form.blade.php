@extends('client.app')

@section('content')
<div class="container" ng-controller="LoginController as login" ng-cloak>
    <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
    
    <div class="form-style form-wide" ng-if="!login.registered" ng-init="login.getTeacherDetails('{!! $id !!}', '{!! $registration_token !!}')">
        <div class="row">
            <div class="col-xs-12 register_users">
                <h4 class="title">Teacher Registration</h4>

                <div class="col-xs-4 col-xs-offset-4">
                    {!! Html::image('/images/user_teacher.png', 'Teacher'
                        , array(
                            'id' => 'user_teacher'
                            ,'class' => 'client-reg-img'
                        )
                    ) !!}
                
                </div>
            </div>

            <div class="col-xs-12">
                <div class="alert alert-error" ng-if="login.errors">
                    <p ng-repeat="error in login.errors"> 
                        {! error !}
                    </p>
                </div>
            </div>

            <div class="col-xs-12" ng-if="!login.record && login.errors">
                <div class="btn-container">
                    {!! Html::link(route('client.registration'), 'Register New Account'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                        )
                    ) !!}
                </div>
            </div>

            <div class="col-xs-12" ng-if="login.record">
            {!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal')) !!}
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('email', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Email Address'
                                    , 'autocomplete' => 'off'
                                    , 'ng-model' => 'login.record.email'
                                    , 'ng-class' => "{ 'required-field' : login.fields['email'] }"
                                    , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                    , 'ng-change' => "login.checkEmailAvailability(login.record.email, 'Client')"
                                )
                            ) !!}

                            <div>
                                <span ng-if="login.validation.e_error" class="error-msg-con">{! login.validation.e_error !}</span>
                                <i ng-if="login.validation.e_loading" class="fa fa-spinner fa-spin"></i>
                                <span ng-if="login.validation.e_success" class="error-msg-con success-color">{! login.validation.e_success !}</span>
                            </div>
                        </div>

                        <label class="col-xs-2 control-label">Username<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('username', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Username'
                                    , 'autocomplete' => 'off'
                                    , 'ng-model' => 'login.record.username'
                                    , 'ng-class' => "{ 'required-field' : login.fields['username'] }"
                                    , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                    , 'ng-change' => "login.checkAvailability(login.record.username, 'Client')"
                                )
                            ) !!}

                            <div> 
                                <span ng-if="login.validation.u_error" class="error-msg-con">{! login.validation.u_error !}</span>
                                <i ng-if="login.validation.u_loading" class="fa fa-spinner fa-spin"></i>
                                <span ng-if="login.validation.u_success" class="error-msg-con success-color">{! login.validation.u_success !}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 control-label">Password<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::password('password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Password'
                                    , 'ng-class' => "{ 'required-field' : login.fields['password'] }"
                                    , 'ng-model' => 'login.record.password'
                                )
                            ) !!}
                            <p class="help-block">Password must be at least 8 characters and with at least 1 number.</p>
                        </div>
                        <label class="col-xs-2 control-label">Confirm Password<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::password('confirm_password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Confirm Password'
                                    , 'ng-class' => "{ 'required-field' : login.fields['password'] }"
                                    , 'ng-model' => 'login.record.confirm_password'
                                )
                            ) !!}
                        </div>
                    </div>   
                </fieldset>

            <fieldset>
                <legend>Personal Information</legend>
                <div class="form-group">
                    <label class="col-xs-2 control-label">First Name<span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('first_name', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'First Name'
                                , 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
                                , 'ng-model' => 'login.record.first_name'
                            )
                        ) !!}
                    </div>
                
                    <label class="col-xs-2 control-label">Last Name<span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('last_name', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'Last Name'
                                , 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
                                , 'ng-model' => 'login.record.last_name'
                            )
                        ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 control-label">Street Address</label>
                    <div class="col-xs-6">
                        {!! Form::text('street_address', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'Street Address'
                                , 'ng-class' => "{ 'required-field' : login.fields['street_address'] }"
                                , 'ng-model' => 'login.record.street_address'
                            )
                        ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 control-label">City</label>
                    <div class="col-xs-4">
                        {!! Form::text('city', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'City'
                                , 'ng-class' => "{ 'required-field' : login.fields['city'] }"
                                , 'ng-model' => 'login.record.city'
                            )
                        ) !!}
                    </div>
                    
                    <label class="col-xs-2 control-label">State</label>
                    <div class="col-xs-4">
                        {!! Form::text('state', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'State'
                                , 'ng-class' => "{ 'required-field' : login.fields['state'] }"
                                , 'ng-model' => 'login.record.state'
                            )
                        ) !!}
                    </div>
                </div>   
            
                <div class="form-group">
                    <label class="col-xs-2 control-label">Postal Code</label>
                    <div class="col-xs-4">
                        {!! Form::text('zip', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'Postal Code'
                                , 'ng-class' => "{ 'required-field' : login.fields['zip'] }"
                                , 'ng-model' => 'login.record.zip'
                            )
                        ) !!}
                    </div>
                
                    <label class="col-xs-2 control-label">Country</label>
                    <div class="col-xs-4" ng-init="getCountries()">
                        <select  name="country_id" ng-class="{ 'required-field' : login.fields['country_id'] }" 
                                class="form-control" ng-model="login.record.country_id">
                            <option value="">-- Select Country --</option>
                            <option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="role-div">
                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">School Name<span class="required">*</span></label>
                        <div class="col-xs-6">
                            {!! Form::text('school_name', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'School Name'
                                    , 'ng-disabled' => 'true'
                                    , 'ng-class' => "{ 'required-field' : login.fields['school_id'] }" 
                                    , 'ng-model' => 'login.record.school_name'
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
                                <input type="checkbox" ng-model="login.terms">
                                I agree on the <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">Terms and Conditions</a> and <a href="#" data-toggle="modal" ng-click="showModal('policy_modal')">Data Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <div class="btn-container col-sm-6 col-sm-offset-3">
                        {!! Form::button('Register'
                            , array(
                                'class' => 'btn btn-blue btn-medium'
                                , 'ng-click' => 'login.updateClientRegistration()'
                            )
                        ) !!}

                        {!! Html::link(route('client.login'), 'Cancel'
                            , array(
                                'class' => 'btn btn-gold btn-medium'
                            )
                        )!!}
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
    {!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
    {!! Html::script('https://apis.google.com/js/platform.js') !!}
    {!! Html::script('https://apis.google.com/js/client.js') !!}

    {!! Html::script('/js/common/validation_service.js')!!}

    {!! Html::script('/js/student/controllers/media_login_controller.js') !!}
    {!! Html::script('/js/student/services/media_login_service.js') !!}

    {!! Html::script('/js/client/controllers/login_controller.js') !!}
    {!! Html::script('/js/client/services/login_service.js') !!}
    {!! Html::script('/js/client/services/profile_service.js') !!}
    {!! Html::script('/js/client/login.js') !!}

@stop