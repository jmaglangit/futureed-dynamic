<div class="login-container form-style" ng-if="login.active_registration_success">
    <div class="title" ng-if="!login.linked">Thank you for registering to Future Lesson!</div>
    <div class="title" ng-if="login.linked">Confirm Your Email Address</div>

    <div class="alert alert-danger" ng-if="login.errors">
        <p ng-repeat="error in login.errors" >
            {! error !}
        </p>
    </div>

    <div ng-if="login.confirmed">
        <div class="tittle">
            <h3>Success!</h3>
        </div>

        <div class="form_content">
            <div class="roundcon">
                <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p>Your email account has been successfully confirmed.</p>

        </div>
    </div>
</div>