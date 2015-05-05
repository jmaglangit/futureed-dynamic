@extends('client.app')

@section('content')
<div class="container" ng-init="registered={!! $registered !!}" ng-cloak>
  <div class="form-style form-wide" ng-if="!registered && !success"> 
    <div ng-show="!success">
      <div class="title">Register as</div>
      <div class="row">
        <div class="col-md-12 register_users">
          <div class="col-md-2 col-md-offset-3" ng-click="selectRole('user_principal')">
            <img id="user_principal" ng-class="{role : !principal}" src="/images/user_principal.jpg" />
            <h4>Principal</h4>
          </div>
          <div class="col-md-2" ng-click="selectRole('user_parent')">
            <img id="user_parent" ng-class="{role : !parent}" src="/images/user_parent.jpg">
            <h4>Parent</h4>
          </div>
        </div>
        <div class="col-md-12">
          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          <form id="form_registation" class="form-horizontal">
            <fieldset>
              <legend>User Credentials</legend>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Email<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text" id="email" class="form-control" ng-model="reg.email" placeholder="Email Address"
                    ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkEmailAvailability(reg.email, 'Client')"/>
                  <span ng-if="e_error" class="error-msg-con">{! e_error !}</span>
                  <div> 
                    <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="e_success" class="fa fa-check success-color"></i>
                  </div>
                </div>
                
                <label for="" class="col-md-2 control-label">Username<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text" id="username" class="form-control" ng-model="reg.username" placeholder="Username"
                    ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkAvailability(reg.username, 'Client')"/>
                  <span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
                  <div> 
                    <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                    <i ng-if="u_success" class="fa fa-check success-color"></i>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Password<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="password" id="password" class="form-control" ng-model="reg.password" placeholder="Password" />
                </div>
                <label for="" class="col-md-2 control-label">Confirm Password<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="password" class="form-control" ng-model="reg.confirm_password" placeholder="Confirm Password" />
                </div>
              </div>   
            </fieldset>
            <fieldset>
              <legend>Personal Information</legend>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">First Name<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="first_name" class="form-control" ng-model="reg.first_name" placeholder="First Name" />
                </div>
                <label for="" class="col-md-2 control-label">Last Name<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="last_name" class="form-control" ng-model="reg.last_name" placeholder="Last Name" />
                </div>
              </div>   
              <div class="form-group" id="form_address">
                <label for="" class="col-md-2 control-label">Street Address<span class="required">*</span></label>
                <div class="col-md-6">
                  <input type="text"  id="street_address" class="form-control" ng-model="reg.street_address" placeholder="Street Address" />
                </div>
              </div>
              <div class="form-group" id="form_address2">
                <label for="" class="col-md-2 control-label">City<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="city" class="form-control" ng-model="reg.city" placeholder="City" />
                </div>
                <label for="" class="col-md-2 control-label">State<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="state" class="form-control" ng-model="reg.state" placeholder="State" />
                </div>
              </div>   
              <div class="form-group" id="form_postcode">
                <label for="" class="col-md-2 control-label">Zip Code<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="zip" class="form-control" ng-model="reg.zip" placeholder="Postal Code" />
                </div>
                <label for="" class="col-md-2 control-label">Country<span class="required">*</span></label>
                <div class="col-md-4" ng-init="getCountries()">
                  <select  id="country" class="form-control" ng-model="reg.country">
                    <option value="">-- Select Country --</option>
                    <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                  </select>
                </div>
              </div>
            </fieldset>
            <div id="principal" ng-if="principal" class="role-div">
              <fieldset>
                <legend>School Information</legend>
                <div class="form-group" id="form_schoolname">
                  <label for="" class="col-md-2 control-label">School Name<span class="required">*</span></label>
                  <div class="col-md-6">
                    <input type="text" id="school_name" class="form-control" ng-model="reg.school_name" placeholder="School Name" />
                  </div>
                </div>
                <div class="form-group" id="form_address">
                <label for="" class="col-md-2 control-label">School Address<span class="required">*</span></label>
                <div class="col-md-6">
                  <input type="text" id="school_address" class="form-control" ng-model="reg.school_address" placeholder="School Address" />
                </div>
              </div>
              <div class="form-group" id="form_address2">
                <label for="" class="col-md-2 control-label">City<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="school_city" class="form-control" ng-model="reg.school_city" placeholder="City" />
                </div>
                <label for="" class="col-md-2 control-label">State<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="school_state" class="form-control" ng-model="reg.school_state" placeholder="State" />
                </div>
              </div>   
              <div class="form-group" id="form_postcode">
                <label for="" class="col-md-2 control-label">Zip Code<span class="required">*</span></label>
                <div class="col-md-4">
                  <input type="text"  id="school_zip" class="form-control" ng-model="reg.school_zip" placeholder="Postal Code" />
                </div>
                <label for="" class="col-md-2 control-label">Country<span class="required">*</span></label>
                <div class="col-md-4" ng-init="getCountries()">
                  <select  id="school_country" class="form-control" ng-model="reg.school_country">
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
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('client.login.registration-success')
  @include('student.login.terms-and-condition')
  @include('student.login.privacy-policy')

</div>
@endsection