<div ng-if="profile.settings">
    <div class="alert alert-error" ng-if="profile.errors">
        <p>
            {! error !}
        </p>
    </div>

<fieldset>
    <legend>Current Background Image</legend>
    <div class="form-group">
        <label for="" class="col-xs-3 control-label">Background Image</label>
        <img ng-src="{! profile.background_image.url !}" class="bg-image-item" alt="{! profile.background_image.name !}">
    </div>

</fieldset>
<fieldset>
    <legend>Select New Background Image</legend>
    <ul class="bg-image-list list-unstyled list-inline ng-scope" ng-init="profile.getBackgroundImage()">
        <li class="item bg-image-item"
            ng-repeat="image in profile.background_image_list"
            ng-click="profile.updateStudentBackgroundImage(image)">
            <img ng-src="{! image.url !}" alt="">
        </li>
    </ul>

</fieldset>
</div>