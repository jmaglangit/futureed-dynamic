@extends('client.app')

@section('content')
<div class="container" ng-init="registered={!! $registered !!}" ng-cloak>
  <div class="form-style form-wide" ng-if="!registered && !success"> 
    <div ng-show="!success">
      <div class="title">Register as</div>
      <div class="row">
        <div class="col-md-12 register_users">
          <div class="col-md-3 col-md-offset-3" ng-click="selectRole('user_principal')">
            <img id="user_principal" ng-class="{role : !principal}" src="/images/user_principal.jpg" />
            <h4>Principal</h4>
          </div>
          <div class="col-md-3" ng-click="selectRole('user_parent')">
            <img id="user_parent" ng-class="{role : !parent}" src="/images/user_parent.jpg">
            <h4>Parent</h4>
          </div>
        </div>
        <div class="col-md-12" ng-if="role_click">
          <div class="alert alert-danger" style="text-align:left;" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          {!! Form::open(array('id' => 'registration_form', 'class' => 'form-horizontal')) !!}
            <fieldset>
              <legend>User Credentials</legend>
              <div class="form-group">
                <label class="col-md-2 control-label">Email<span class="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('email', ''
                        , array(
                              'class' => 'form-control'
                            , 'placeholder' => 'Email Address'
                            , 'ng-model' => 'reg.email'
                            , 'ng-model-options' => "{debounce : {'default' : 1000}}"
                            , 'ng-change' => "checkEmailAvailability(reg.email, 'Client')"
                        )
                  ) !!}

                  <div>
                    <span ng-if="e_error" class="error-msg-con">{! e_error !}</span>
                    <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="e_success" class="fa fa-check error-msg-con success-color"> Email address is available.</i>
                  </div>
                </div>
                
                <label class="col-md-2 control-label">Username<span class="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('username', ''
                        , array(
                              'class' => 'form-control'
                            , 'placeholder' => 'Username'
                            , 'ng-model' => 'reg.username'
                            , 'ng-model-options' => "{debounce : {'default' : 1000}}"
                            , 'ng-change' => "checkAvailability(reg.username, 'Client')"
                        )
                  ) !!}
                  <div> 
                    <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="u_success" class="fa fa-check error-msg-con success-color"> Username is available.</i>
                    <span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
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
                        , 'ng-model' => 'reg.password'
                      )
                  ) !!}
                </div>
                <label class="col-md-2 control-label">Confirm Password<span class="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::password('confirm_password'
                      , array(
                          'class' => 'form-control'
                        , 'placeholder' => 'Confirm Password'
                        , 'ng-model' => 'reg.confirm_password'
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
                          , 'ng-model' => 'reg.first_name'
                        )
                  ) !!}
                </div>
                <label class="col-md-2 control-label">Last Name<span class="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('last_name', ''
                        , array(
                          'class' => 'form-control'
                          , 'placeholder' => 'Last Name'
                          , 'ng-model' => 'reg.last_name'
                        )
                  ) !!}
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label">Street Address<span class="required" ng-if="required">*</span></label>
                <div class="col-md-6">
                  {!! Form::text('street_address', ''
                        , array(
                          'class' => 'form-control'
                          , 'placeholder' => 'Street Address'
                          , 'ng-model' => 'reg.street_address'
                        )
                  ) !!}
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label">City<span class="required" ng-if="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('city', ''
                          , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'City'
                            , 'ng-model' => 'reg.city'
                          )
                    ) !!}
                </div>
                <label class="col-md-2 control-label">State<span class="required" ng-if="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('state', ''
                        , array(
                          'class' => 'form-control'
                          , 'placeholder' => 'State'
                          , 'ng-model' => 'reg.state'
                        )
                  ) !!}
                </div>
              </div>   
              <div class="form-group">
                <label class="col-md-2 control-label">Zip Code<span class="required" ng-if="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('zip', ''
                        , array(
                          'class' => 'form-control'
                          , 'placeholder' => 'Postal Code'
                          , 'ng-model' => 'reg.zip'
                        )
                  ) !!}
                </div>
                <label class="col-md-2 control-label">Country<span class="required" ng-if="required">*</span></label>
                <div class="col-md-4" ng-init="getCountries()">
                  <select  name="country" class="form-control" ng-model="reg.country">
                    <option value="">-- Select Country --</option>
                    <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                  </select>
                </div>
              </div>
            </fieldset>
            <div id="principal" ng-if="principal" class="role-div">
              <fieldset>
                <legend>School Information</legend>
                <div class="form-group">
                  <label class="col-md-2 control-label">School Name<span class="required">*</span></label>
                  <div class="col-md-6">
                    {!! Form::text('school_name', ''
                        , array(
                          'class' => 'form-control'
                          , 'placeholder' => 'School Name'
                          , 'ng-model' => 'reg.school_name'
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
                        , 'ng-model' => 'reg.school_address'
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
                        , 'ng-model' => 'reg.school_city'
                      )
                  ) !!}
                </div>
                <label class="col-md-2 control-label">State<span class="required">*</span></label>
                <div class="col-md-4">
                  {!! Form::text('school_state', ''
                      , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'State'
                        , 'ng-model' => 'reg.school_state'
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
                        , 'ng-model' => 'reg.school_zip'
                      )
                  ) !!}
                </div>
                <label class="col-md-2 control-label">Country<span class="required">*</span></label>
                <div class="col-md-4" ng-init="getCountries()">
                  <select  name="school_country" class="form-control" ng-model="reg.school_country">
                    <option value="">-- Select Country --</option>
                    <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                  </select>
                </div>
              </div> 
              </fieldset>
            </div>
            <div class="block_bottom">
              <fieldset>
                <div class="form-group">
                  <div class="checkbox text-center">
                    <label>
                      <input type="checkbox" ng-model="term">
                      I agree on the <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">Terms and Conditions</a> and <a href="#" ng-click="showModal('policy_modal')">Data Privacy Policy</a>
                    </label>
                  </div>
                </div>
                <div class="btn-container col-sm-6 col-sm-offset-3">
                  <a ng-click="registerClient(reg, term)" type="button" class="btn btn-blue btn-medium">Register</a>
                  <a href="{!! route('client.login') !!}" type="button" class="btn btn-gold btn-medium">Cancel</a>
                </div>
              </fieldset>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>

  @include('client.login.registration-success')
  @include('student.login.terms-and-condition')
  @include('student.login.privacy-policy')

</div>
@endsection