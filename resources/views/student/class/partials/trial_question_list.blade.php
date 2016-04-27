<div class="row">

    <div class="col-xs-12 class-container">
        <ul class="nav nav-pills module-pills" role="tablist" ng-init="class.listClass()">
            <li role="presentation" class="module-tabs" ng-class="{ 'active' : aClass.class_id == class.current_class }">
                <a href="#">{{ trans_choice('messages.module', 1) }}</a>
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
                                <p class="trial-module-name">{{ trans('messages.trial_module') }}</p>
                            </center>
                            <center>
                                <button type="button"
                                        ng-click="class.redirect('{!! route('student.class.module.trial-index') !!}')"
                                        class="trial-btn btn-blue trial-module-btn margin-bottom-15">
                                    <i class="fa fa-pencil"></i> {{ trans('messages.begin') }}
                                </button>
                            </center>
                            <center>
                                <h4 class="margin-top-30 trial-module-message">
                                    {{ trans('messages.trial_module_message_1') }}<a href="{{ route('student.payment.index') }}" class="payment-page-text">{{ trans('messages.trial_module_payment_page_text') }}</a>
                                </h4>
                                <h4 class="trial-module-message">
                                    {{ trans('messages.trial_module_message_2') }}
                                </h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>