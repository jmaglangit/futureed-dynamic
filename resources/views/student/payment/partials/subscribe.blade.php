<div ng-if="payment.active_add">
    {{--Headers progress breadcrumb arrow Start > SUBJECT > SUBSCRIPTION > DAYS > DETAILS > PAY --}}
    {!! Html::script('/js/common/subscription_service.js')!!}
    <div class="wizard-content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.add_payment') !!}</span>

            <div class="col-xs-2 pull-right top-10">
                <a href="{!! route('student.class.index') !!}" class="btn btn-maroon">{!! trans('messages.back') !!}</a>
            </div>
        </div>

    </div>
    <div class="wizard-row">
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Subject">
                            <span class="round-tab">
                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Plan">
                            <span class="round-tab">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Days">
                            <span class="round-tab">
                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Other Information">
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
                            <h3>Subject</h3>

                            {{--Display subject options--}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>
                                        <a href="#" class="btn btn-sq-lg btn-primary">
                                            <span><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
                                            <br>
                                            English
                                        </a>
                                        <a href="#" class="btn btn-sq-lg btn-success">
                                            <span><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
                                            <br>
                                            Vocabulary
                                        </a>
                                        <a href="#" class="btn btn-sq-lg btn-info">
                                            <span><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
                                            <br>
                                            Math
                                        </a>
                                        <a href="#" class="btn btn-sq-lg btn-warning">
                                            <span><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
                                            <br>
                                            Dictionary
                                        </a>
                                    </p>
                                </div>
                            </div>


                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-primary next-step">Save and continue</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h3>Plans</h3>

                            <p>This is step 2</p>
                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">Previous</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-primary next-step">Save and continue</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <h3>Days</h3>

                            <p>This is step 3</p>
                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">Previous</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-default next-step">Skip</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-primary btn-info-full next-step">Save and
                                        continue
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Complete</h3>

                            <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                {!! Form::close() !!}
            </div>
        </section>
    </div>
</div>
