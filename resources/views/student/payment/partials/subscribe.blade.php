<div ng-if="payment.active_add">
    {{--Headers progress breadcrumb arrow Start > SUBJECT > SUBSCRIPTION > DAYS > DETAILS > PAY --}}
    {!! Html::script('/js/common/subscription_service.js')!!}
    {!! Html::script('/js/common/form_service.js')!!}
    <div class="wizard-content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.add_payment') !!}</span>

            <div class="col-xs-2 pull-right top-10">
                <a href="{!! route('student.class.index') !!}" class="btn btn-maroon">{!! trans('messages.back') !!}</a>
            </div>
        </div>

    </div>
    <div class="wizard-row" ng-init="payment.subscriptionPackage(futureed.SUBSCRIPTION_COUNTRY); payment.subscriptionOption()">
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Country">
                            <span class="round-tab">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Subject">
                            <span class="round-tab">
                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Plan">
                            <span class="round-tab">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Days">
                            <span class="round-tab">
                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Other Information">
                            <span class="round-tab">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                    </ul>
                </div>
                {!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h3>Country</h3>

                            {{--Display subject options --}}
                            {{--TODO get subject list--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>
                                        <a ng-repeat="country in payment.subscription_country" href="#" class="wizard-box btn btn-sq-lg btn-primary"
                                                ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_COUNTRY,country.id)">
                                            <span><i class="fa fa-5x fa-flag " aria-hidden="true"></i></span>
                                            <br>
                                            {! country.name !}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h3>Subject</h3>

                            {{--Display subject options --}}
                            {{--TODO get subject list--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>
                                        <a ng-repeat="subject in payment.subscription_subject" href="#" class="wizard-subject wizard-box btn btn-sq-lg btn-primary"
                                           ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_SUBJECT,subject.id)">
                                            <span><i class="fa fa-5x fa-folder-open-o" aria-hidden="true"></i></span>
                                            <br>
                                            {! subject.name !}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <h3>Plans</h3>

                            {{--Display list of plan--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <div ng-repeat="plan in payment.subscription_plan" class="wizard-panel panel panel-primary panel-horizontal"
                                         ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_PLAN,plan.id)">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{! plan.name !}</h3>
                                        </div>
                                        <div class="panel-body">{! plan.description !}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step4">
                            <h3>Days</h3>

                            {{--List plans available days.--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <div ng-repeat="days in payment.subscription_days" class="wizard-panel panel panel-primary panel-horizontal"
                                         ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_DAYS,days.id)">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-calendar" aria-hidden="true"></i></h3>
                                        </div>
                                        <div class="panel-body"><h3>{! days.days!} days</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step5">
                            <h3>Additional Information</h3>

                            {{--Other information--}}
                            {{--TODO add js script on change from text to input--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4>Billing Information</h4>

                                    <div class="form-search">
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label h4">Name:</label>

                                            <label class="col-lg-4 h4 form-label" name="user_name">{! payment.billing_information.name !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label h4 ">City:</label>

                                            <label class="col-lg-4 h4 form-label" name="user_city" >{! payment.billing_information.city !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label h4">State:</label>

                                            <label class="col-lg-4 h4 form-label" name="user_state">{! payment.billing_information.state !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label h4">Country:</label>

                                            <label class="col-lg-4 h4 form-label" name="user_country">{! payment.billing_information.country.full_name !}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-gold btn-info-full" ng-if="!payment.billing_info"
                                            ng-click="payment.modifyUserAddress(futureed.TRUE)">Edit</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-gold btn-info-full" ng-if="payment.billing_info"
                                            ng-click="payment.modifyUserAddress(futureed.FALSE)">Save</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-primary btn-info-full next-step"
                                            ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_OTHERS,futureed.FALSE)">Continue</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Billing Invoice</h3>

                            <div class="row">
                                <div class="col-xs-12">
                                    {{--user information--}}

                                    {{--invoice details--}}

                                    <div class="col-xs-6 search-container">
                                        {{--country--}}
                                        <div><label>Country : {! payment.subscription_packages.country.name !}</label></div>
                                        {{--subject--}}
                                        <div><label>Subject : {! payment.subscription_packages.subject.name !}</label></div>
                                        {{--Subscription / plan--}}
                                        <div><label>Plan : {! payment.subscription_packages.subscription.name !}</label></div>
                                        {{--Days--}}
                                        <div><label>Days : {! payment.subscription_packages.subscription_day.days !}</label></div>
                                        {{--price--}}
                                        <div><label>Price : {! payment.subscription_packages.price !}</label></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-primary">Save</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-gold">Pay Subscription</button>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
