
  <div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2" ng-if="email_pass">        
        <div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>

        {!! Form::open(array('id' => 'password_form', 'method' => 'POST', 'route' => 'student.login.process')) !!}
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
          </div>
          <input type="hidden" name="user_data" >
        {!! Form::close() !!}

        <div class="btn-container">
            <button class="btn btn-maroon btn-medium" ng-click="changeBack()">Previous</button>
            <button class="btn btn-gold btn-medium" ng-click="changeValidate()">Next</button>
        </div>
  </div>
  