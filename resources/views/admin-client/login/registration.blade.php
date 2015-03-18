@extends('app')

@section('content')
<div class="container">
  <div class="form-style form-wide"> 
    <div class="title">Register as</div>
    <div class="row">
      <div class="col-md-12 register_users">
        <div class="col-md-4"><img id="user_principal" src="images/user_principal.jpg" alt=""><h4>Principal</h4></div>
        <div class="col-md-4"><img id="user_teacher" src="images/user_teacher.jpg" alt=""><h4>Teacher</h4></div>
        <div class="col-md-4"><img id="user_parent" src="images/user_parent.jpg" alt=""><h4>Parent</h4></div>
      </div>
      <div class="col-md-12">
        <form class="form-horizontal">
          <fieldset>
            <legend>Personal Information</legend>
            <div class="form-group">
              <label for="" class="col-md-2 control-label">First Name</label>
              <div class="col-md-4"><input type="text" class="form-control"></div>
              <label for="" class="col-md-2 control-label">Last Name</label>
              <div class="col-md-4"><input type="text" class="form-control"></div>
            </div>   
          </fieldset>
          <fieldset>
            <legend>User Credentials</legend>
            <div class="form-group">
              <label for="" class="col-md-2 control-label">Email</label>
              <div class="col-md-4"><input type="text" class="form-control"></div>
              <label for="" class="col-md-2 control-label">Username</label>
              <div class="col-md-4"><input type="text" class="form-control"></div>
            </div>
            <div class="form-group">
              <label for="" class="col-md-2 control-label">Password</label>
              <div class="col-md-4"><input type="password" class="form-control"></div>
              <label for="" class="col-md-2 control-label">Confirm Password</label>
              <div class="col-md-4"><input type="password" class="form-control"></div>
            </div>   
          </fieldset>
          <div id="principal">
          <fieldset>
            <legend>School Information</legend>
            <div class="form-group" id="form_schoolname">
              <label for="" class="col-md-2 control-label">School Name</label>
              <div class="col-md-6"><input type="text" class="form-control"></div>
            </div>
            <div class="form-group" id="form_address">
              <label for="" class="col-md-2 control-label">Address</label>
              <div class="col-md-6"><input type="text" class="form-control"></div><br><br>
              <div class="col-md-6 col-md-offset-2"><input type="text" class="form-control"></div>
            </div>
            <div class="form-group" id="form_address2">
              <label for="" class="col-md-2 control-label">City</label>
              <div class="col-md-2"><input type="text" class="form-control"></div>
              <label for="" class="col-md-2 control-label">State</label>
              <div class="col-md-2"><input type="text" class="form-control"></div>
            </div>   
            <div class="form-group" id="form_postcode">
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
          <div id="parent" style="display:none;">
          <fieldset>
            <legend>Address</legend>
            <div class="form-group">
              <label for="" class="col-md-2 control-label">Street Address</label>
              <div class="col-md-6"><input type="text" class="form-control"></div><br><br>
              <div class="col-md-6 col-md-offset-2"><input type="text" class="form-control"></div>
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
                    I agree on the <a href="#">Terms and Conditions</a>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                  <div class="form-group">
                    <div class="submit">REGISTER</div>
                  </div>    
                </div>
              </div>
            </fieldset>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection