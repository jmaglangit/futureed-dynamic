
  <div class="enter-pass-con form-select-password" ng-if="enter_pass">
      <div ng-if="!locked">
        <div class="title">Please Select Your Password</div>
        <div class="error" ng-if="error">
          <p>{! error !}</p>
        </div>
        <form id="password_form" action="{!! route('student.login.process') !!}" method="POST">
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in image_pass" ng-click="selectPassword($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
          </div>
          <input type="hidden" name="user_data" >
        </form>

        <div class="btncon">
            <button class="btn btn-purple" ng-click="cancelLogin()">Cancel</button>
        </div>
      </div>
  </div>
  