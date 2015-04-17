
  <div class="enter-pass-con form-select-password" ng-if="enter_pass">
      <div ng-if="!locked">
        <div class="title">Please Select Your Password</div>
        <div class="error" ng-if="error">
          <p>{! error !}</p>
        </div>
        <form id="password_form" action="{!! route('student.login.process') !!}" name="passwordForm" method="POST">
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.password_image_file !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
              <p><button type="button" class="btn btn-red" ng-click="validatePassword()">Submit</button></p>
            </ul>
          </div>
          <input type="hidden" id="response" name="response" >
        </form>
      </div>
  </div>
  