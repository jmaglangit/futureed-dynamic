<div class="col-xs-12 padding-0">
    <div ng-if="!mod.question_hide" class="margin-top-50">
        <div class="questions-container col-xs-12">
            {{--Header--}}
            <div class="row questions-header col-xs-12">
                <div class="row col-xs-3">
                    <button type="button" class="btn btn-gold next-btn left-0"
                            ng-click="mod.exitModule('{!! route('student.dashboard.index') !!}')"> {{ trans('messages.exit_module') }} </button>
                </div>

                <div class="row col-xs-6">
                    <center><h3> {{ trans('messages.question') }} #{! mod.question_number + 1 !} </h3></center>
                </div>

                <div class="row col-xs-3">
                    <button
                            {{--ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed"--}}
                            type="button" class="btn btn-orange next-btn right-0"
                            ng-click="mod.validateAnswer()"> {{ trans('messages.submit')}} </button>
                </div>

            </div>
            <div class="question-contents">
                {{--Error Messages--}}
                <div class="col-xs-12">
                    <div class="alert trial-question-alert-error" ng-if="mod.errors">
                        <p ng-repeat="error in mod.errors track by $index">
                            {! error !}
                        </p>
                    </div>

                    <div class="alert alert-success" ng-if="mod.success">
                        <p>{! mod.success !}</p>
                    </div>
                </div>
                <div class="col-xs-6">
                    {{--Image--}}
                    <div class="col-xs-12">
                        <div class="questions-image">
                            <img ng-if="mod.trialQuestion[mod.question_number]['question_image'] != 'none'"
                                 ng-src="{! mod.trialQuestion[mod.question_number]['question_image'] !}"/>
                        </div>
                    </div>
                    {{--Message--}}
                    <div class="col-xs-12">
                        <div class="questions-message">
                            <p ng-bind-html="mod.trialQuestion[mod.question_number]['question'] | trustAsHtml"></p>
                        </div>
                    </div>
                    {{--Tips--}}
                    <div class="col-xs-12">
                        <div class="questions-tips"
                             ng-class="{'question-tip-pos-top-10' : mod.trialQuestion[mod.question_number]['question_image'] != 'none', 'question-tip-pos-top-130' : mod.trialQuestion[mod.question_number]['question_image'] == 'none'}"
                             ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.ORDERING">
                            <p> <img ng-src="{! user.avatar !}" /> <span>{{ trans('messages.drag_items_reorder') }} </span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    {{--Answers--}}
                    <div class="questions-answers">

                        {{--MC--}}
                        <div class="margin-top-30">
                            <a ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.MULTIPLECHOICE" href=""
                               class="choices"
                               ng-repeat="choices in mod.trialQuestion[mod.question_number]['number_of_choices']"
                               ng-click="mod.selectAnswer(choices)" ng-class="{ 'selected-choice' : mod.current_question.answer_id == choices }"
                            >
                                <div ng-if="mod.trialQuestion[mod.question_number]['choices_list'][choices]['string_choice'] != 'none'">
                                    {! mod.trialQuestion[mod.question_number]['choices_list'][choices]['string_choice'] !}
                                </div>
                                <div ng-if="mod.trialQuestion[mod.question_number]['choices_list'][choices]['image_choice'] != 'none'">
                                    <img ng-src="{! mod.trialQuestion[mod.question_number]['choices_list'][choices]['image_choice'] !}"/>
                                </div>
                            </a>
                        </div>

                        {{--FIB--}}
                        <div class="margin-top-30">
                            <div ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.FILLINBLANK" class="form-group">
                                <div ng-class="{ 'fib-text-fields' : mod.trialQuestion[mod.question_number]['number_of_blanks'].length }">
                                    <input ng-repeat="n in mod.trialQuestion[mod.question_number]['number_of_blanks'] track by $index"
                                           ng-model="mod.fib_answer[$index]"
                                           name="answer_text"
                                           type="text" class="form-control question-text-answer form-control-lg" placeholder="Answer {! $index + 1 !}"
                                    />
                                </div>
                            </div>
                        </div>

                        {{--N--}}
                        <div class="margin-top-30">
                            <div ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.PROVIDE" class="form-group">
                                <input ng-model="mod.answer"
                                       name="answer_text"
                                       type="text"
                                       class="form-control question-text-answer form-control-lg" placeholder="Answer"/>
                            </div>
                        </div>

                        {{--O--}}
                        <div class="margin-top-30">
                            <div ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.ORDERING">
                                <ul as-sortable="mod.dragControlListeners" ng-model="mod.trialQuestion[mod.question_number]['unordered_list']">
                                    <li ng-repeat="item in mod.trialQuestion[mod.question_number]['unordered_list']"
                                        as-sortable-item class="as-sortable-item">
                                        <div as-sortable-item-handle class="as-sortable-item-handle">
                                            <span data-ng-bind="item"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{--GR--}}
                        <div class="margin-top-30">
                            <div ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.GRAPH">
                                {{--Horizontal--}}
                                <table id="horizontalTable" class="table" ng-if="mod.trialQuestion[mod.question_number]['orientation'] == futureed.HORIZONTAL">
                                    <tr ng-repeat="item in mod.trialQuestion[mod.question_number]['table_image'] track by $index">
                                        <th class="origin-container" ng-init="mod.initDrag()">
                                            <div class="origin">
                                                <img ng-src="{! item.path !}" alt="item.field"/>
                                            </div>
                                        </th>
                                        <td ng-init="mod.initDrop()" class="drop first">
                                        </td>
                                        <td ng-init="mod.initDrop()" class="drop disabled" ng-repeat="col in mod.trialQuestion[mod.question_number]['number_of_columns']" ng-if="$index > 0">
                                        </td>
                                    </tr>
                                </table>
                                {{--Vertical--}}
                                <table id="verticalTable" class="table" ng-if="mod.trialQuestion[mod.question_number]['orientation'] == futureed.VERTICAL">

                                    <tr>
                                        <th ng-repeat="item in mod.trialQuestion[mod.question_number]['table_image']"
                                            ng-init="mod.initDrag()">
                                            <div class="origin">
                                                <img ng-src="{! item.path !}" alt="item.field"/>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td ng-repeat="item in mod.trialQuestion[mod.question_number]['table_image']" ng-init="mod.initDrop()" class="drop first">
                                        </td>
                                    </tr>
                                    <tr ng-repeat="col in mod.trialQuestion[mod.question_number]['number_of_columns']" ng-if="$index > 0">
                                        <td ng-repeat="item in mod.trialQuestion[mod.question_number]['table_image']" ng-init="mod.initDrop()" class="drop disabled">
                                        </td>
                                    </tr>

                                </table>
                                <div class="col-xs-3 pull-right reset-graph">
                                    <button class="btn btn-gold" ng-click="mod.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                </div>
                            </div>
                        </div>

                        {{--QUAD--}}
                        <div class="margin-top-30">
                            <div ng-if="mod.trialQuestion[mod.question_number]['type'] == futureed.QUADRANT">
                                <div ng-init="mod.getQuadrant()">
                                    <div id="placeholder" style="width:300px;height:300px;margin:0 auto;"></div>
                                    <div class="col-xs-3 pull-right reset-graph">
                                        <button class="btn btn-gold" ng-click="mod.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <div ng-if="mod.show_correct" class="margin-top-50">
        <div class="questions-container col-xs-12">
            <div class="questions-header">
                <h3> {{ trans('messages.question') }} #{! mod.question_number + 1 !} </h3>
            </div>

            <div class="result-image">
                <i class="fa fa-5x img-rounded text-center"
                   ng-class="{ 'fa-times' : !mod.answer_valid, 'fa-check' : mod.answer_valid }"></i>
            </div>

            <div class="result-message"
                 ng-class="{ 'result-correct' : mod.answer_valid, 'result-incorrect' : !mod.answer_valid }">
                <p ng-if="mod.answer_valid">
                    {{ trans('messages.correct') }}
                </p>

                <p ng-if="!mod.answer_valid">
                    {{ trans('messages.wrong') }}
                </p>
            </div>

            <div class="proceed-btn-container btn-container">
                <button type="button" class="btn btn-maroon btn-medium" ng-click="mod.nextQuestion()">
                    {{ trans('messages.proceed_to_next_questions') }}
                </button>
            </div>
        </div>
    </div>

    <div ng-if="mod.trial_expired" class="margin-top-50">
        <div class="questions-container col-xs-12">
            <div class="questions-header">
                <h3> {{ trans('messages.question') }} #{! mod.question_number + 1 !} </h3>
            </div>

            <div class="result-failed message-container">
                <div class="col-xs-12">
                    <div class="col-xs-2"></div>
                    <div class="module-icon-holder col-xs-3">
                        <img ng-src="{! user.avatar !}" />
                    </div>

                    <div class="col-xs-6">
                        <p class="module-message">
                            {{ trans('messages.end_of_trial_question') }}
                            <p class="font-size-16" ng-if="user.age > 13"><span class="fa fa-lightbulb-o"></span>{{ trans('messages.end_of_trial_question_age_greater_13') }}</p>
                            <p class="font-size-16" ng-if="user.age <= 13">{{ trans('messages.end_of_trial_question_age_below_13') }}</p>
                        </p>

                        <div class="trial-proceed-btn-container btn-container">
                            <button type="button" class="btn trial-btn-maroon btn-large" ng-click="mod.exitModule('{!! route('student.payment.index') !!}')">
                                {{ trans('messages.subscribe_now') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>