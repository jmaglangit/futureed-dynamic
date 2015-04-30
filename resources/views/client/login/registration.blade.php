@extends('client.app')

@section('content')
<div class="container" ng-cloak>
  <div class="form-style form-wide" ng-init="success=false;"> 
    <div ng-if="success">
      <div class="title">Thank you for registering to FutureEd!</div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center" style="margin-top:40px; margin-bottom:40px;">
          You're almost done! You should be able to receive an email confirmation in a few minutes. Please check your inbox or your spam folder and click on the email confirmation link.
        </div>
      </div>
    </div>

    <div ng-show="!success">
      <div class="title">Register as</div>
      <div class="row">
        <div class="col-md-12 register_users">
          <div class="col-md-2 col-md-offset-3" ng-click="selectRole('user_principal')">
            <img id="user_principal" ng-class="{role : !principal}" src="/images/user_principal.jpg" />
            <h4>Principal</h4>
          </div>
          <div class="col-md-2" ng-click="selectRole('user_teacher')">
            <img id="user_teacher" ng-class="{role : !teacher}" src="/images/user_teacher.jpg" />
            <h4>Teacher</h4>
          </div>
          <div class="col-md-2" ng-click="selectRole('user_parent')">
            <img id="user_parent" ng-class="{role : !parent}" src="/images/user_parent.jpg">
            <h4>Parent</h4>
          </div>
        </div>
        <div class="col-md-12">
          <form class="form-horizontal">
            <fieldset>
              <legend>User Credentials</legend>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Email<span class="required">*</span></label>
                <div class="col-md-4"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">Username<span class="required">*</span></label>
                <div class="col-md-4"><input type="text" class="form-control"></div>
              </div>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Password<span class="required">*</span></label>
                <div class="col-md-4"><input type="password" class="form-control"></div>
                <label for="" class="col-md-2 control-label">Confirm Password<span class="required">*</span></label>
                <div class="col-md-4"><input type="password" class="form-control"></div>
              </div>   
            </fieldset>
            <fieldset>
              <legend>Personal Information</legend>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">First Name<span class="required">*</span></label>
                <div class="col-md-4"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">Last Name<span class="required">*</span></label>
                <div class="col-md-4"><input type="text" class="form-control"></div>
              </div>   
            </fieldset>
            <div id="teacher" ng-if="teacher" class="role-div">
            <fieldset>
              <legend>School Information</legend>
              <div class="form-group" id="form_schoolname">
                <label for="" class="col-md-2 control-label">School Name<span class="required">*</span></label>
                <div class="col-md-6"><input type="text" class="form-control"></div>
              </div> 
            </fieldset>
            </div>
            <div id="principal" ng-if="principal" class="role-div">
            <fieldset>
              <legend>School Information</legend>
              <div class="form-group" id="form_schoolname">
                <label for="" class="col-md-2 control-label">School Name<span class="required">*</span></label>
                <div class="col-md-6"><input type="text" class="form-control"></div>
              </div>
              <div class="form-group" id="form_address">
                <label for="" class="col-md-2 control-label">Address<span class="required">*</span></label>
                <div class="col-md-6">
                  <textarea class="form-control" ng-model="reg.address"></textarea>
                </div>
              </div>
              <div class="form-group" id="form_address2">
                <label for="" class="col-md-2 control-label">City<span class="required">*</span></label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">State<span class="required">*</span></label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
              </div>   
              <div class="form-group" id="form_postcode">
                <label for="" class="col-md-2 control-label">Postal Code<span class="required">*</span></label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">Country<span class="required">*</span></label>
                <div class="col-md-2" ng-init="getCountries()">
                  <select class="form-control" ng-model="reg.country">
                    <option value="">-- Select Country --</option>
                    <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                  </select>
                </div>
              </div>   
            </fieldset>
            </div>
            <div id="parent" ng-if="parent" class="role-div">
            <fieldset>
              <legend>Address</legend>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Street Address</label>
                <div class="col-md-6">
                  <textarea class="form-control" ng-model="reg.address"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-md-2 control-label">City</label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">State</label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
              </div>   
              <div class="form-group">
                <label for="" class="col-md-2 control-label">Postal Code</label>
                <div class="col-md-2"><input type="text" class="form-control"></div>
                <label for="" class="col-md-2 control-label">Country</label>
                <div class="col-md-2">
                  <select class="form-control">
                    <option value="Philippines" title="Philippines">Philippines</option>
                    <option value="Singapore" title="Singapore">Singapore</option>
                    <option value="United States" title="United States">United States</option>
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
                      <input type="checkbox" value="">
                      I agree on the <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">Terms and Conditions</a> and <a href="#" ng-click="showModal('policy_modal')">Data Privacy Policy</a>
                    </label>
                  </div>
                </div>
                <div class="btn-container col-sm-6 col-sm-offset-3">
                  <a ng-click="" type="button" class="btn btn-blue btn-medium">Register</a>
                  <a href="{!! route('client.login') !!}" type="button" class="btn btn-gold btn-medium">Cancel</a>
                </div>
              </fieldset>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('student.login.terms-and-condition')
  @include('student.login.privacy-policy')

</div>
@endsection