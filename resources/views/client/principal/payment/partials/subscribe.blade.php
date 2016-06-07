<div ng-if="payment.active_add || payment.active_view">
    {{--Headers progress breadcrumb arrow Start > SUBJECT > SUBSCRIPTION > DAYS > DETAILS > PAY --}}
    {!! Html::script('/js/common/subscription_service.js')!!}
    {!! Html::script('/js/common/form_service.js')!!}
    <div class="wizard-content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.add_payment') !!}</span>
        </div>

    </div>
    <div class="wizard-row">
        <div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" >
                {! error !}
            </p>
        </div>
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs parent" role="tablist">

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
                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Classroom">
                            <span class="round-tab">
                                <i class="fa fa-university" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Other Information">
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
                            <h3>Classroom</h3>
                            <div class="row">
                                <div class="form-group" ng-init="payment.getGradeLevel(user.country_id); payment.getSchoolCode()">
                                    <table ng-table="tableClassroom" class="table table-condensed table-classroom">
                                        <thead>
                                        <tr>
                                            <td class="h5">No. of Seats</td>
                                            <td class="h5">Grade</td>
                                            <td class="h5">Teacher</td>
                                            <td class="h5">Class</td>
                                            <td class="h5">Price</td>
                                            <td class="h5">Actions</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="(key,classroom) in payment.subscription_classroom" ng-if="classroom">
                                            <td class="h5">{! classroom.seats !}</td>
                                            <td class="h5">{! classroom.grade.name !}</td>
                                            <td class="h5">{! classroom.teacher.name !}</td>
                                            <td class="h5">{! classroom.class_name !}</td>
                                            <td class="h5">{! classroom.price !}</td>
                                            <td class="h5"><a class="btn btn-primary " ng-click="payment.removeClassroom(key,payment.subscription_classroom)">DELETE</a></td>
                                        </tr>
                                        <tr>
                                            <td class="h5">
                                                {!! Form::text('seats', ''
                                                        , [
                                                            'class' => 'form-control'
                                                            , 'placeholder' => 'no. of seats'
                                                            , 'ng-model' => 'payment.new_classroom.seats']
                                                    ) !!}
                                            </td>
                                            <td class="h5">
                                                <select name="grade_id" ng-disabled="!grades.length" ng-class="{ 'required-field' : payment.fields['grade_id'] }" class="form-control" ng-model="payment.new_classroom.grade_id">
                                                    <option ng-selected="payment.classroom.grade_id == futureed.false" value="">{!! trans('messages.select_level') !!}</option>
                                                    <option ng-selected="payment.classroom.grade_id == grade.id" ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
                                                </select>
                                            </td>
                                            <td class="h5">
                                                {!! Form::text('teacher',''
                                                    , array(
                                                        'placeHolder' => trans('messages.teacher')
                                                        , 'ng-model' => 'payment.classroom.client_name'
                                                        , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                                        , 'ng-class' => "{ 'required-field' : payment.fields['client_id'] }"
                                                        , 'ng-change' => "payment.suggestTeacher()"
                                                        , 'class' => 'form-control'
                                                    )
                                                ) !!}

                                                <div class="angucomplete-holder" ng-if="payment.teachers.length">
                                                    <ul class="col-xs-5 angucomplete-dropdown">
                                                        <li class="angucomplete-row" ng-repeat="teacher in payment.teachers" ng-click="payment.selectTeacher(teacher)">
                                                            {! teacher.first_name !} {! teacher.last_name !}
                                                        </li>
                                                    </ul>
                                                </div>

                                            </td>
                                            <td class="h5">
                                                {!! Form::text('class_name', ''
                                                       , array(
                                                           'class' => 'form-control'
                                                           , 'placeholder' => 'name'
                                                           , 'ng-model' => 'payment.new_classroom.class_name')
                                                   ) !!}
                                            </td>
                                            <td class="h5">{! (((payment.new_classroom.seats) ?  payment.new_classroom.seats : 0)
                                                * payment.subscription_invoice.package_price) !}
                                            </td>
                                            <td class="h5">
                                                <div ng-model="button" class="btn btn-primary"
                                                     ng-disabled="(!payment.new_classroom.seats || !payment.new_classroom.grade_id
                                                        || !payment.subscription_teacher || !payment.new_classroom.class_name)"
                                                     ng-click="payment.getClassroomGrade(payment.new_classroom.grade_id)"
                                                        >Add Classroom</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-primary btn-info-full"
                                            ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_CLASSROOM)"
                                            ng-disabled="(payment.subscription_classroom.length == 0)"
                                            >Next</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step6">
                            <h3>Additional Information</h3>
                            <div class="row" ng-if="payment.active_add" ng-init="payment.subscriptionOption(futureed.SUBSCRIPTION_OTHERS)">
                                <div class="col-xs-12 invoice-form">
                                    <h4>Billing Information</h4>

                                    <div class="form-search">
                                        <div ng-if="!payment.billing_info">
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">Name:</label>

                                                <label class="col-lg-4 h4 form-label" name="user_name">{!
                                                    payment.billing_information.name !}</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4 ">City:</label>

                                                <label class="col-lg-4 h4 form-label" name="user_city">{!
                                                    payment.billing_information.city !}</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">State:</label>

                                                <label class="col-lg-4 h4 form-label" name="user_state">{!
                                                    payment.billing_information.state !}</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">Country:</label>

                                                <label class="col-lg-4 h4 form-label" name="user_country">{!
                                                    payment.billing_information.country.name !}</label>
                                            </div>
                                        </div>
                                        <div ng-if="payment.billing_info">
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">Name:</label>

                                                <label class="col-lg-4 h4 form-label" name="user_name">{!
                                                    payment.billing_information.name !}</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4 ">City:</label>
                                                <div class="col-lg-4">
                                                    {!! Form::text('city', ''
                                                        , array(
                                                            'class' => 'form-control'
                                                            , 'placeholder' => trans('messages.city')
                                                            , 'ng-model' => 'payment.billing_information.city')
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">State:</label>
                                                <div class="col-lg-4">
                                                    {!! Form::text('state', ''
                                                        , array(
                                                            'class' => 'form-control'
                                                            , 'placeholder' => trans('messages.state')
                                                            , 'ng-model' => 'payment.billing_information.state')
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label h4">Country:</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control" name="user_country"
                                                            ng-init="getCountries()"
                                                            ng-model="payment.billing_information.country.id">
                                                        <option ng-selected="payment.billing_information.country.id == futureed.FALSE"
                                                                value="">{!! trans('messages.select_country') !!}</option>
                                                        <option ng-selected="payment.billing_information.country.id == country.id"
                                                                ng-repeat="country in countries"
                                                                ng-value="country.id">{! country.name !}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
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
                                    <button ng-model="button" ng-disabled="!payment.subscription_continue"
                                            type="button" class="btn btn-primary btn-info-full next-step"
                                            ng-click="payment.subscriptionOption(futureed.SUBSCRIPTION_OTHERS,futureed.FALSE)">Continue</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Billing Invoice</h3>

                            <div class="row">
                                <div class="col-xs-12 invoice-form">
                                    <div class="form-search">
                                        <div>
                                            <div class="h4 col-xs-9">Subscription Summary</div>
                                            <div class="col-md-3 h4 alert"
                                                 ng-class="{'alert-info' : payment.subscription_invoice.payment_status == futureed.PAID
                                                 , 'alert-danger' : payment.subscription_invoice.payment_status == futureed.PENDING}">
                                                <center>{! payment.subscription_invoice.payment_status !}</center></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">SUBJECT : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_packages.subject.name !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">SUBSCRIPTION PLAN : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_packages.subscription.name !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">No. of Days : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_packages.subscription_day.days !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">Date period : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_invoice.date_start_string !} - {! payment.subscription_invoice.date_end_string !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">Country : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_packages.country.name !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">with Learning Style : </label>
                                            <label ng-if="!payment.subscription_packages.subscription.has_lsp" class="col-lg-4 h5 form-label">{! futureed.NO !}</label>
                                            <label ng-if="payment.subscription_packages.subscription.has_lsp" class="col-lg-4 h5 form-label">{! futureed.YES !}</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">Price : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_packages.price !} USD</label>
                                        </div>

                                    </div>
                                    <div class="wizard-content-title"></div>
                                    <div class="form-search">
                                        <div class="h4">Classroom</div>
                                        <div class="form-group">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <td class="h5">No. of Seats</td>
                                                        <td class="h5">Grade</td>
                                                        <td class="h5">Teacher</td>
                                                        <td class="h5">Class</td>
                                                        <td class="h5">Price</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="classroom in payment.subscription_invoice.classrooms">
                                                        <td class="h5">{! classroom.seats !}</td>
                                                        <td class="h5">{! classroom.grade.name !}</td>
                                                        <td class="h5">{! classroom.teacher.name !}</td>
                                                        <td class="h5">{! classroom.class_name !}</td>
                                                        <td class="h5">{! classroom.price !}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="wizard-content-title"></div>
                                    <div class="form-search">
                                        <div class="h4">Total Price Computation</div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">SUBTOTAL : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_invoice.sub_total !} USD</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">DISCOUNT : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_invoice.discount ?  payment.subscription_invoice.discount : 0.00 !}%</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label h5">TOTAL : </label>
                                            <label class="col-lg-4 h5 form-label">{! payment.subscription_invoice.total_amount !} USD</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li ng-if="payment.active_add || payment.active_pay || payment.subscription_invoice.payment_status == futureed.PENDING">
                                    <button ng-click="payment.paySubscription()" type="button" class="btn btn-gold">
                                        Pay Subscription
                                    </button>
                                </li>
                                <li ng-if="!payment.active_view">
                                    <button ng-click="payment.saveSubscription()" type="button" class="btn btn-primary">
                                        Save
                                    </button>
                                </li>
                                <li ng-if="payment.invoice.expired && payment.active_renew && !payment.active_pay">
                                    <button ng-click="payment.renewSubscription(); payment.renewPayment()" type="button" class="btn btn-primary">
                                        Renew Subscription
                                    </button>
                                </li>
                                <li ng-if="payment.active_view">
                                    <button ng-click="payment.setActive(Constants.ACTIVE_LIST)" type="button" class="btn btn-gold">
                                        View List
                                    </button>
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
