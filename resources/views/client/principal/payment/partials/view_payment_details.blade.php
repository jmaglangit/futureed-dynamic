<div ng-if="payment.active_view">
    <div class="content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.client_view_sales_invoice') !!}</span>
        </div>
    </div>

    <div class="col-xs-12 success-container" ng-if="payment.errors">
        <div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index">
                {! error !}
            </p>
        </div>
    </div>

    {!! Form::open(array('class' => 'form-horizontal')) !!}
    <div class="form-content col-xs-12" ng-init="payment.getSchoolCode()">
        <div ng-if="payment.invoice.payment_status == futureed.PENDING">
            <fieldset class="payment-field">
                <span class="step">1</span>

                <p class="step-label">{!! trans('messages.please_select_subject') !!}</p>

                <div class="col-xs-12">
                    <div class="form-search">
                        <div class="form-group">
                            <label class="col-xs-3 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>

                            <div class="col-xs-5" ng-init="payment.getSubject()">
                                <select class="form-control" ng-disabled="!payment.subjects.length"
                                        ng-model="payment.invoice.subject_id"
                                        ng-class="{ 'required-field' : payment.fields['subject_id'] }">
                                    <option value="">{!! trans('messages.select_subject') !!}</option>
                                    <option ng-selected="payment.invoice.subject_id == subject.id"
                                            ng-repeat="subject in payment.subjects" ng-value="subject.id">{!
                                        subject.name !}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <hr/>

            <fieldset class="payment-field" ng-if="!payment.invoice.renew">
                <span class="step">2</span>

                <p class="step-label">{!! trans('messages.please_add_classroom') !!}</p>

                <div class="col-xs-12">
                    <div class="form-search">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" id="email">{!! trans('messages.no_of_seats') !!} <span
                                        class="required">*</span></label>

                            <div class="col-xs-5">
                                {!! Form::text('seats_total',''
                                    , array(
                                        'placeHolder' => 'trans('messages.no_of_seats')'
                                        , 'ng-model' => 'payment.classroom.seats_total'
                                        , 'ng-class' => "{ 'required-field' : payment.fields['seats_total'] }"
                                        , 'ng-disabled' => "payment.invoice.renew"
                                        , 'class' => 'form-control'
                                    )
                                ) !!}
                            </div>
                        </div>

                        <div class="form-group" ng-init="getGradeLevel(user.country_id)">
                            <label class="col-xs-3 control-label">{!! trans('messages.grade') !!} <span class="required">*</span></label>

                            <div class="col-xs-5">
                                <select name="grade_id" ng-disabled="!grades.length || payment.invoice.renew"
                                        ng-class="{ 'required-field' : payment.fields['grade_id'] }"
                                        class="form-control" ng-model="payment.classroom.grade_id">
                                    <option ng-selected="payment.classroom.grade_id == futureed.false" value="">{!! trans('messages.select_level') !!}
                                    </option>
                                    <option ng-selected="payment.classroom.grade_id == grade.id"
                                            ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" id="email">{!! trans('messages.teacher') !!} <span
                                        class="required">*</span></label>

                            <div class="col-xs-5">
                                {!! Form::text('teacher',''
                                    , array(
                                        'placeHolder' => 'trans('messages.teacher')'
                                        , 'ng-model' => 'payment.classroom.client_name'
                                        , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                        , 'ng-class' => "{ 'required-field' : payment.fields['client_id'] }"
                                        , 'ng-change' => "payment.suggestTeacher()"
                                        , 'ng-disabled' => "payment.invoice.renew"
                                        , 'class' => 'form-control'
                                    )
                                ) !!}

                                <div class="angucomplete-holder" ng-if="payment.teachers.length">
                                    <ul class="col-xs-5 angucomplete-dropdown">
                                        <li class="angucomplete-row" ng-repeat="teacher in payment.teachers"
                                            ng-click="payment.selectTeacher(teacher)">
                                            {! teacher.first_name !} {! teacher.last_name !}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="margin-top-8"
                                 ng-if="payment.validation.c_loading || payment.validation.c_error">
                                <i ng-if="payment.validation.c_loading" class="fa fa-spinner fa-spin"></i>
                                <span ng-if="payment.validation.c_error" class="error-msg-con">{! payment.validation.c_error !}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label">{!! trans('messages.class') !!} <span class="required">*</span></label>

                            <div class="col-xs-5">
                                {!! Form::text('name',''
                                    , array(
                                        'placeHolder' => 'trans('messages.class')'
                                        , 'ng-model' => 'payment.classroom.name'
                                        , 'ng-class' => "{ 'required-field' : payment.fields['name'] }"
                                        , 'autocomplete' => 'off'
                                        , 'ng-disabled' => "payment.invoice.renew"
                                        , 'class' => 'form-control'
                                    )
                                ) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="btn-container col-xs-offset-2 col-xs-7">
                                {!! Form::button('trans('messages.update')'
                                    , array(
                                        'class' => 'btn btn-blue btn-medium'
                                        , 'ng-click' => 'payment.updateClassroom()'
                                        , 'ng-if' => 'payment.classroom.update'
                                    )
                                ) !!}

                                {!! Form::button('trans('messages.add_classroom')'
                                    , array(
                                        'class' => 'btn btn-blue btn-medium'
                                        , 'ng-click' => 'payment.addClassroom()'
                                        , 'ng-if' => '!payment.classroom.update'
                                        , 'ng-disabled' => "payment.invoice.renew"
                                    )
                                ) !!}

                                {!! Form::button('trans('messages.clear')'
                                    , array(
                                        'class' => 'btn btn-gold btn-medium'
                                        , 'ng-click' => 'payment.clearClassroom()'
                                        , 'ng-disabled' => "payment.invoice.renew"
                                    )
                                ) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
            </fieldset>

            <fieldset class="payment-field">
                <span class="step" ng-if="!payment.invoice.renew">3</span>
                <span class="step"  ng-if="payment.invoice.renew">2</span>

                <p class="step-label">{!! trans('messages.please_select_subscription') !!}</p>

                <div class="col-xs-12">
                    <div class="form-search">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">{!! trans('messages.subscription') !!}</label>

                            <div class="col-xs-4">
                                <select
                                        ng-model="payment.invoice.subscription_id"
                                        ng-disabled="!payment.subscriptions.length || payment.invoice.payment_status !== futureed.PENDING"
                                        ng-init="payment.listSubscription()"
                                        ng-change="payment.selectSubscription()"
                                        class="form-control"
                                        name="subscription_id"
                                        ng-class="{ 'required-field' : payment.fields['subscription_id'] }">

                                    <option value="">{!! trans('messages.select_subscription') !!}</option>
                                    <option ng-selected="payment.invoice.subscription_id == subscription.id"
                                            ng-repeat="subscription in payment.subscriptions"
                                            ng-value="subscription.id">{! subscription.name !}
                                    </option>
                                </select>
                            </div>
                            <label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>

                            <div class="col-xs-4">
                                {!! Form::text('name',''
                                    , array(
                                        'placeHolder' => 'trans('messages.payment_status')'
                                        , 'ng-model' => 'payment.invoice.payment_status'
                                        , 'ng-disabled' => 'true'
                                        , 'class' => 'form-control'
                                    )
                                ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">{!! trans('messages.starting') !!}</label>

                            <div class="col-xs-4">
                                <input class="form-control" ng-disabled="true"
                                       value="{! payment.invoice.dis_date_start | ddMMyy !}" placeholder="DD/MM/YY"/>
                            </div>
                            <label class="col-xs-2 control-label">{!! trans('messages.to') !!}</label>

                            <div class="col-xs-4">
                                <input class="form-control" ng-disabled="true"
                                       value="{! payment.invoice.dis_date_end | ddMMyy !}" placeholder="DD/MM/YY"/>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div ng-if="payment.invoice.payment_status == futureed.PAID || payment.invoice.payment_status == futureed.CANCELLED">
            <fieldset class="payment-field">
                <div class="col-xs-12">
                    <h4>{!! trans('messages.billing_invoice') !!}</h4>

                    <div class="invoice-group">
                        <p>Ref: {! payment.invoice.client_name !} {! payment.invoice.id !} / {!! date('Y') !!}</p>
                    </div>
                    <div class="invoice-group">
                        <p>{!! trans('messages.date') !!} : {{ date('d/m/Y') }}</p>
                    </div>
                    <div class="invoice-group margin-10-bot">
                        <p class="bill-info">{! payment.invoice.client_name !}</p>

                        <p class="bill-info">{! payment.user.street_address !}</p>

                        <p class="bill-info">{! payment.user.city !} {! payment.user.state !} {! payment.user.zip !}</p>

                        <p class="bill-info">{! payment.user.country !}</p>
                    </div>
                    <div class="invoice-group">
                        <p class="bill-info">{!! trans('messages.bill_to') !!}:</p>

                        <p class="bill-info">{! futureed.BILL_COMPANY !}</p>

                        <p class="bill-info">{! futureed.BILL_STREET !}</p>

                        <p class="bill-info">{! futureed.BILL_ADDRESS !}</p>

                        <p class="bill-info">{! futureed.BILL_COUNTRY !}</p>
                    </div>
                </div>
            </fieldset>

            <hr/>

            <fieldset>
                <div class="col-xs-12">
                    <div class="form-search">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">{!! trans('messages.subject') !!} </label>

                            <div class="col-xs-4">
                                <input class="form-control" ng-disabled="true"
                                       value="{! payment.invoice.subject_name !}" placeholder="Subject"/>
                            </div>
                            <label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>

                            <div class="col-xs-4">
                                {!! Form::text('name',''
                                    , array(
                                        'placeHolder' => 'trans('messages.payment_status')'
                                        , 'ng-model' => 'payment.invoice.payment_status'
                                        , 'ng-disabled' => 'true'
                                        , 'class' => 'form-control'
                                    )
                                ) !!}
                            </div>
                            <div class="col-xs-6"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-2 control-label">{!! trans('messages.subscription') !!}</label>

                            <div class="col-xs-4">
                                <select ng-model="payment.invoice.subscription_id"
                                        ng-disabled="!payment.subscriptions.length || payment.invoice.payment_status !== futureed.PENDING"
                                        ng-init="payment.listSubscription()"
                                        ng-change="payment.selectSubscription()"
                                        class="form-control"
                                        name="subscription_id"
                                        ng-class="{ 'required-field' : payment.fields['subscription_id'] }">

                                    <option value="">{!! trans('messages.select_subscription') !!}</option>
                                    <option ng-selected="payment.invoice.subscription_id == subscription.id"
                                            ng-repeat="subscription in payment.subscriptions"
                                            ng-value="subscription.id">{! subscription.name !}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-2 control-label">{!! trans('messages.starting') !!}</label>

                            <div class="col-xs-4">
                                <input class="form-control" ng-disabled="true"
                                       value="{! payment.invoice.dis_date_start | ddMMyy !}" placeholder="DD/MM/YY"/>
                            </div>
                            <label class="col-xs-2 control-label">{!! trans('messages.to') !!}</label>

                            <div class="col-xs-4">
                                <input class="form-control" ng-disabled="true"
                                       value="{! payment.invoice.dis_date_end | ddMMyy !}" placeholder="DD/MM/YY"/>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <fieldset class="payment-field">
            <div class="col-xs-12">
                <div class="list-container" ng-cloak>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>{!! trans('messages.no_of_seats') !!}</th>
                            <th>{!! trans('messages.grade') !!}</th>
                            <th>{!! trans('messages.teacher') !!}</th>
                            <th>{!! trans('messages.class') !!}</th>
                            <th>{!! trans('messages.price') !!}</th>
                            <th ng-if="payment.invoice.payment_status == futureed.PENDING && !payment.invoice.renew">
                                {!! trans('messages.action') !!}
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr ng-repeat="room in payment.classrooms">
                            <td>{! room.seats_total !}</td>
                            <td>{! room.grade.name !}</td>
                            <td>{! room.client.first_name !} {! room.client.last_name !}</td>
                            <td>{! room.name !}</td>
                            <td>{! room.price | currency : "USD$ " : 2 !}</td>
                            <td ng-if="payment.invoice.payment_status == futureed.PENDING && !payment.invoice.renew">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="" ng-click="payment.getClassroom(room.id)"><span><i
                                                        class="fa fa-pencil"></i></span></a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="" ng-click="payment.removeClassroom(room.id)"><span><i
                                                        class="fa fa-trash"></i></span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd" ng-if="!payment.classrooms.length && !payment.table.loading">
                            <td valign="top" colspan="7">
                                {!! trans('messages.no_records_found') !!}
                            </td>
                        </tr>
                        <tr class="odd" ng-if="payment.table.loading">
                            <td valign="top" colspan="7">
                                {!! trans('messages.loading') !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>

        <fieldset class="payment-field">
            <div class="form-group">
                <div class="col-xs-6"></div>
                <div class="col-xs-6 div-right">
                    <label class="col-xs-4 control-label">{!! trans('messages.subtotal') !!}</label>

                    <div class="col-xs-8">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">USD$</span>
                            <input type="text" ng-disabled="true" class="form-control"
                                   value="{! payment.invoice.sub_total | currency : '' : 2 !}" placeholder="Subtotal"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-6"></div>
                <div class="col-xs-6 div-right">
                    <label class="col-xs-4 control-label">{!! trans('messages.discount') !!}</label>

                    <div class="col-xs-8">
                        <div class="input-group">
                            {!! Form::text('discount',''
                                , [
                                    'ng-disabled' => true
                                    , 'class' => 'form-control'
                                    , 'ng-model' => 'payment.invoice.discount'

                                ]
                            ) !!}
                            <span class="input-group-addon" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-6"></div>
                <div class="col-xs-6 div-right">
                    <label class="col-xs-4 control-label">{!! trans('messages.total') !!}</label>

                    <div class="col-xs-8">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">USD$</span>
                            <input type="text" ng-disabled="true" class="form-control"
                                   value="{! payment.invoice.total_amount | currency : '' : 2 !}" placeholder="Total"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div ng-if="payment.invoice.payment_status !== futureed.PENDING">
                    <div class="invoice-group">
                        <p>{!! trans('messages.no_signature_req') !!}<br/>
                            {!! trans('messages.electronic_invoice') !!}</p>
                    </div>
                    <div class="invoice-group">
                        <p>{!! trans('messages.payment_method') !!}:<br/>
                            {!! trans('messages.direct_credit_to') !!}: {! futureed.CC_NAME !}<br/>
                            {!! trans('messages.bank_name') !!}: {! futureed.BANK_NAME !}<br/>
                            {!! trans('messages.bank_account_number') !!}: <br/>
                            {! futureed.BANK_ACCT_NO_SGD !}<br/>
                            {! futureed.BANK_ACCT_NO_USD !}<br/>
                            {!! trans('messages.bank_address') !!}: {! futureed.BANK_ADDRESS !}<br/>
                            {!! trans('messages.bank_code') !!}: {! futureed.BANK_CODE !}
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <div class="btn-container">
                        <div ng-if="payment.invoice.payment_status == futureed.PENDING">
                            {!! Form::button('trans('messages.pay_subscription')'
                                , array(
                                    'class' => 'btn btn-blue btn-semi-medium'
                                    , 'ng-click' => 'payment.addPayment()'
                                )
                            ) !!}

                            {!! Form::button('trans('messages.save_subscription')'
                                , array(
                                    'class' => 'btn btn-blue btn-semi-medium'
                                    , 'ng-click' => 'payment.savePayment()'
                                )
                            ) !!}

                            {!! Form::button('trans('messages.delete_subscription')'
                                , array(
                                    'class' => 'btn btn-gold btn-semi-medium'
                                    , 'ng-click' => 'payment.deleteInvoice(payment.invoice.id)'
                                )
                            ) !!}
                        </div>
                        <div ng-if="payment.invoice.payment_status !== futureed.PENDING">
                            <hr/>
                            {!! Form::button('trans('messages.view_list')'
                                , array(
                                    'class' => 'btn btn-gold btn-semi-medium pull-right'
                                    , 'ng-click' => 'payment.setActive()'
                                )
                            ) !!}

                            {!! Form::button('trans('messages.renew_subscription')'
                                , array(
                                    'class' => 'btn btn-blue btn-semi-medium pull-right'
                                    , 'ng-disabled' => '!payment.invoice.expired'
                                    , 'ng-click' => 'payment.renewSubscription()'
                                    , 'ng-if' => "payment.invoice.payment_status == futureed.PAID"
                                )
                            ) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group"></div>
        </fieldset>
    </div>
    {!! Form::close() !!}
</div>