@extends('export.billing.index')

@section('metadata')
@stop


@section('content')
    <div>
        <h3>{!! ucfirst(trans('messages.billing_invoice')) !!}</h3>

        <div class="row">
            <div class="col-xs-12 invoice-form">
                {{--@include('common.invoice_header')--}}
                @if($invoice['client'])
                <div>
                    <b>Ref :</b> KCGA {!! $invoice['client_name'] !!} {!! $invoice['id'] !!}/{!! date('Y') !!}<br>
                    <b>{!! trans('messages.date') !!} :</b> {!! $invoice['order']['order_date'] !!}<br><br>
                    {!! config('futureed.billing_address.company') !!}.<br>
                    {!! config('futureed.billing_address.street') !!}<br>
                    {!! config('futureed.billing_address.address') !!}<br>
                    {!! config('futureed.billing_address.country') !!}<br><br>
                    <b>{!! trans('messages.bill_to') !!} :</b> {!! $invoice['client_name'] !!}<br>
                    {!! $invoice['client']['street_address'] !!}, {!! $invoice['client']['city'] !!}{!! ',' . $invoice['client']['state'] !!}{!! ',' . $invoice['client']['country']['name'] !!}<br>
                    <b>Attention :</b> {!! $invoice['client']['school']['contact_name'] !!}<br>
                </div>
                @endif
                @if($invoice['student'])
                <div>
                    <b>Ref :</b> KCGA {!! $invoice['student_name'] !!} {!! $invoice['id'] !!}/{!! date('Y') !!}<br>
                    <b>{!! trans('messages.date') !!} :</b> {!! $invoice['order']['order_date'] !!}<br><br>
                    {!! config('futureed.billing_address.company') !!}.<br>
                    {!! config('futureed.billing_address.street') !!}<br>
                    {!! config('futureed.billing_address.address') !!}<br>
                    {!! config('futureed.billing_address.country') !!}<br><br>
                    <b>{!! trans('messages.bill_to') !!} :</b> {!! $invoice['student_name'] !!}<br>
                    {!! $invoice['student']['city'] !!}{!! ',' . $invoice['student']['state'] !!}{!! ',' . $invoice['student']['country']['name'] !!}<br>
                    <b>Attention :</b> {!! $invoice['student']['school']['contact_name'] !!}<br><br>
                </div>
                @endif
                <br/>
                {{--subscription summary--}}
                <div class="form-search">
                    <div>
                        <div><b>{!! trans('messages.subscription_summary') !!}</b></div><br>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.status') !!} :</b> </label>
                        <label >{!! $invoice['payment_status'] !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.subject') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription_package']['subject']['name'] !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.subscription_plan') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription']['name'] !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.no_of_days') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription_package']['subscription_day']['days'] !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.date_period') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! \Carbon\Carbon::parse($invoice['date_start'])->formatLocalized('%B %d %Y') !!} - {!! \Carbon\Carbon::parse($invoice['date_end'])->formatLocalized('%B %d %Y') !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.country') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription_package']['country']['name'] !!}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.with_learning_style') !!} :</b> </label>
                        @if(!$invoice['subscription']['has_lsp'])
                        <label ng-if="!payment.subscription_packages.subscription.has_lsp" class="col-lg-4 h5 form-label">{!! trans('messages.no') !!}</label>
                        @endif
                        @if($invoice['subscription']['has_lsp'])
                        <label ng-if="payment.subscription_packages.subscription.has_lsp" class="col-lg-4 h5 form-label">{!! trans('messages.yes') !!}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.price') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription_package']['price'] !!} USD</label>
                    </div>

                </div><br/>
                {{--If Principal--}}
                @if($invoice['client'] && $invoice['client']['client_role'] == config('futureed.principal'))
                <div class="wizard-content-title"></div>
                <div class="form-search">
                    <div><b>{!! trans('messages.classroom') !!}</b></div><br>
                    <div class="form-group">
                        <table class="export-table">
                            <thead>
                            <tr>
                                <th>{!! trans_choice('messages.no_of_seats',2) !!}</th>
                                <th>{!! trans_choice('messages.grade',1) !!}</th>
                                <th>{!! trans('messages.teacher') !!}</th>
                                <th>{!! trans('messages.class') !!}</th>
                                <th>{!! ucfirst(trans('price')) !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice['invoice_detail'] as $details)
                                <tr>
                                    <td>{!! number_format($details['classroom']['seats_total']) !!}</td>
                                    <td>{!! $details['grade']['name'] !!}</td>
                                    <td>{!! $details['classroom']['client']['user']['name'] !!}</td>
                                    <td>{!! $details['classroom']['name'] !!}</td>
                                    <td>{!! number_format($details['price'], 2, '.', '') !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                {{--If Parent--}}
                @if($invoice['client'] && $invoice['client']['client_role'] == config('futureed.parent'))
                <div class="wizard-content-title"></div>
                <div class="form-search">
                    <div><b>{!! trans_choice('messages.student',2) !!}</b></div><br>
                    <div class="form-group">
                        <table class="export-table">
                            <thead>
                            <tr>
                                <th colspan="3" align="center">{!! trans('messages.name') !!}</th>
                                <th colspan="3" align="center">{!! trans('messages.email') !!}</th>
                                <th colspan="3" align="center">{!! trans('messages.price') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice['invoice_detail'][0]['classroom']['class_student'] as $students)
                                <tr>
                                    <td colspan="3">{!! $students['student']['user']['name'] !!}</td>
                                    <td colspan="3">{!! $students['student']['user']['email'] !!}</td>
                                    <td colspan="3">{!! $invoice['subscription_package']['price'] !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{--Total Computation--}}
                <div class="wizard-content-title"></div><br/>
                <h4 class="form-search">
                    <div><b>{!! trans('messages.total_price_computation') !!}</b></div><br>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.subtotal') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['subscription_package']['price'] !!} USD</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.discount') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['discount'] !!} %</label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label h5"><b>{!! trans('messages.total') !!} :</b> </label>
                        <label class="col-lg-4 h5 form-label">{!! $invoice['total_amount']!!} USD</label>
                    </div>
                </div>
                {{--@include('common.invoice_footer')--}}
                <div><br>
                    <b>{!! trans('messages.payment_method') !!} :</b> <br/>
                    <b>{!! trans('messages.direct_credit_to') !!} :</b> {!! config('futureed.billing_address.cc_name') !!}<br/>
                    <b>{!! trans('messages.bank_name') !!} :</b> {!! config('futureed.billing_address.bank_name') !!}<br/>
                    <b>{!! trans('messages.sgd_branch_code') !!} :</b> {!! config('futureed.billing_address.sgd_branch_code') !!}, <b>{!! trans('messages.account') !!} :</b> {!! config('futureed.billing_address.sgd_acct_no') !!}<br/>
                    <b>{!! trans('messages.usd_branch_code') !!} :</b> {!! config('futureed.billing_address.usd_branch_code') !!}, <b>{!! trans('messages.account') !!} :</b> {!! config('futureed.billing_address.usd_acct_no') !!}<br/>
                    <b>{!! trans('messages.bank_code') !!} :</b> {!! config('futureed.billing_address.bank_code') !!}, <b>{!! trans('messages.swift_code') !!} :</b> {!! config('futureed.billing_address.swift_code') !!}
                </div>
            </div>
        </div>

    </div>
@stop