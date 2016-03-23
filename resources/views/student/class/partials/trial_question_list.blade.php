<div class="row">

    <div class="col-xs-12 class-container">
        <ul class="nav nav-pills module-pills" role="tablist" ng-init="class.listClass()">
            <li role="presentation" class="module-tabs" ng-class="{ 'active' : aClass.class_id == class.current_class }">
                <a href="#">Module</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="list-container" ng-cloak>
                    <div class="clearfix"></div>

                    <div class="module-list">
                        <div class="module-item">
                            <div class="module-image-holder">
                                <img class="module-icon"
                                     ng-src="{!! url('/trial-module/images/module/icon-spatial.png') !!}"
                                     ng-click="class.redirect('{!! route('student.class.module.trial-index') !!}')"
                                     tooltip-class="module-tooltip"
                                     tooltip-placement="bottom"
                                     tooltip="Trial Module">
                            </div>

                            <p class="module-name">Trial Module</p>

                            <button type="button"
                                    ng-click="class.redirect('{!! route('student.class.module.trial-index') !!}')"
                                    class="btn btn-blue module-btn margin-bottom-15"><i class="fa fa-pencil"></i> Begin </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>