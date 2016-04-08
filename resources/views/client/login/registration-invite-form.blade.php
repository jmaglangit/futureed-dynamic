@extends('client.app')

@section('content')
<div class="container" ng-controller="LoginController as login" 
    ng-init="login.getTeacherDetails('{!! $id !!}', '{!! $registration_token !!}')" ng-cloak>
    <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
    
    <div class="form-style form-wide" ng-if="login.active_registration" >
        <div class="row">
            <div class="col-xs-12 register_users">
                <h4 class="title">{!! trans('messages.client_teacher_registration') !!}</h4>

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

            <div class="col-xs-12" ng-if="login.record.invited">
                <div class="btn-container">
                    {!! Html::link(route('client.registration'), trans('messages.client_register_new_account')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                        )
                    ) !!}
                </div>
            </div>

            <div class="col-xs-12" ng-if="!login.record.invited">
            {!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal')) !!}
                <fieldset>
                    <legend>{!! trans('messages.user_credentials') !!}</legend>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">{!! trans('messages.email') !!}<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('email', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => trans('messages.email_address')
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

                        <label class="col-xs-2 control-label">{!! trans('messages.username') !!}<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('username', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => trans('messages.username')
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
                        <label class="col-xs-2 control-label">{!! trans('messages.password') !!}<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::password('password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => trans('messages.password')
                                    , 'ng-class' => "{ 'required-field' : login.fields['password'] }"
                                    , 'ng-model' => 'login.record.password'
                                )
                            ) !!}
                            <p class="help-block">{!! trans('messages.password_limit') !!}</p>
                        </div>
                        <label class="col-xs-2 control-label">{!! trans('messages.confirm_password') !!}<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::password('confirm_password'
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => trans('messages.confirm_password')
                                    , 'ng-class' => "{ 'required-field' : login.fields['password'] }"
                                    , 'ng-model' => 'login.record.confirm_password'
                                )
                            ) !!}
                        </div>
                    </div>   
                </fieldset>

            <fieldset>
                <legend>{!! trans('messages.personal_info') !!}</legend>
                <div class="form-group">
                    <label class="col-xs-2 control-label">{!! trans('messages.first_name') !!}<span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('first_name', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.first_name')
                                , 'ng-class' => "{ 'required-field' : login.fields['first_name'] }"
                                , 'ng-model' => 'login.record.first_name'
                            )
                        ) !!}
                    </div>
                
                    <label class="col-xs-2 control-label">{!! trans('messages.last_name') !!}<span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('last_name', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.last_name')
                                , 'ng-class' => "{ 'required-field' : login.fields['last_name'] }"
                                , 'ng-model' => 'login.record.last_name'
                            )
                        ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 control-label">{!! trans('messages.street_address') !!}</label>
                    <div class="col-xs-6">
                        {!! Form::text('street_address', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.street_address')
                                , 'ng-class' => "{ 'required-field' : login.fields['street_address'] }"
                                , 'ng-model' => 'login.record.street_address'
                            )
                        ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 control-label">{!! trans('messages.city') !!}</label>
                    <div class="col-xs-4">
                        {!! Form::text('city', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.city')
                                , 'ng-class' => "{ 'required-field' : login.fields['city'] }"
                                , 'ng-model' => 'login.record.city'
                            )
                        ) !!}
                    </div>
                    
                    <label class="col-xs-2 control-label">{!! trans('messages.state') !!}</label>
                    <div class="col-xs-4">
                        {!! Form::text('state', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.state')
                                , 'ng-class' => "{ 'required-field' : login.fields['state'] }"
                                , 'ng-model' => 'login.record.state'
                            )
                        ) !!}
                    </div>
                </div>   
            
                <div class="form-group">
                    <label class="col-xs-2 control-label">{!! trans('messages.postal_code') !!}</label>
                    <div class="col-xs-4">
                        {!! Form::text('zip', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => trans('messages.postal_code')
                                , 'ng-class' => "{ 'required-field' : login.fields['zip'] }"
                                , 'ng-model' => 'login.record.zip'
                            )
                        ) !!}
                    </div>
                
                    <label class="col-xs-2 control-label">{!! trans('messages.country') !!}</label>
                    <div class="col-xs-4" ng-init="getCountries()">
                        <select  name="country_id" ng-class="{ 'required-field' : login.fields['country_id'] }" 
                                class="form-control" ng-model="login.record.country_id">
                            <option value="">{!! trans('messages.select_country') !!}</option>
                            <option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="role-div">
                <fieldset>
                    <legend>{!! trans('messages.school_info') !!}</legend>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">{!! trans('messages.school_name') !!}<span class="required">*</span></label>
                        <div class="col-xs-6">
                            {!! Form::text('school_name', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => trans('messages.school_name')
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
                                {!! trans('messages.i_agree') !!} <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">{!! trans('messages.terms_and_conditions') !!}</a> {!! trans('messages.and') !!} <a href="#" data-toggle="modal" ng-click="showModal('policy_modal')">{!! trans('messages.data_privacy_policy') !!}</a>
                            </label>
                        </div>
                    </div>

                    <div class="btn-container col-sm-6 col-sm-offset-3">
                        {!! Form::button(trans('messages.register')
                            , array(
                                'class' => 'btn btn-blue btn-medium'
                                , 'ng-click' => 'login.updateClientRegistration()'
                            )
                        ) !!}

                        {!! Html::link(route('client.login'), trans('messages.cancel')
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