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

                    <div class="module-list row">

                        <div class="trial-module-item col-xs-12">
                            <center>
                                <div class="module-image-holder">
                                    <img class="trial-module-icon"
                                         ng-src="{!! url('images/trial-module/images/module/icon-spatial.png') !!}"
                                         ng-click="class.redirect('{!! route('student.class.module.trial-index') !!}')"
                                         tooltip-class="module-tooltip"
                                         tooltip-placement="bottom"
                                         tooltip="Trial Module">
                                </div>
                            </center>
                            <center>
                                <p class="trial-module-name">Trial Module</p>
                            </center>
                            <center>
                                <button type="button"
                                        ng-click="class.redirect('{!! route('student.class.module.trial-index') !!}')"
                                        class="trial-btn btn-blue trial-module-btn margin-bottom-15">
                                    <i class="fa fa-pencil"></i> Begin
                                </button>
                            </center>
                            <center>
                                <h4 class="margin-top-30 trial-module-message">
                                    This is a Trial Module. If you would like to subscribe, please proceed to the <a href="{{ route('student.payment.index') }}" class="payment-page-text">Payment Page</a>
                                </h4>
                                <h4 class="trial-module-message">
                                    OR have a parent or teacher invite you to a class.
                                </h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>