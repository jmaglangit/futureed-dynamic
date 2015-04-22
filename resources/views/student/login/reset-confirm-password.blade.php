<div class="col-md-8 col-md-offset-2" ng-if="password_selected">
  <form id="reset_password_form" action="@if($new){!!route('student.login.set-password-success')!!}@else{!!route('student.login.reset-password-success')!!}@endif" name="reset_password_form" method="POST">
    <div class="form-style form-select-password">
      <div id="title" class="title">Select a picture to confirm your new password</div>
      <div class="error" ng-if="error">
        <p>{! error !}</p>
      </div>
      <div class="form_content">
        <ul class="confirm_form_password list-unstyled list-inline">
          <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
             <img ng-src="{! item.url !}" alt="{! item.name !}">
             <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
          </li>
        </ul>
        <div class="row">
          <div class="col-sm-6"><button type="button" ng-click="undoNewPassword()" class="btn btn-red">Previous</button></div>
          <div class="col-sm-6"><button type="button" class="btn btn-red" ng-click="validateNewPassword('{!! $new !!}')">Reset</a></div>
        </div>

      </div>

      <input type="hidden" name="code" id="code" value="{!! $code !!}" />
      <input type="hidden" name="id" id="id" value="{!! $id !!}" />
      <input type="hidden" name="selected_image_id" id="selected_image_id" />
      <input type="hidden" name="image_pass" />
    </div>
  </form>
</div>