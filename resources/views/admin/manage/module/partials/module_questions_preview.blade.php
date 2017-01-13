{{--whole page--}}
<div>

   {{--header--}}
    <div class="col-md-12 row content-title">
        <span class="h4">{! question.module_name !} {{ trans('messages.admin_preview') }}</span>
        <span class="h5">
            <i class="fa fa-angle-right"></i> {{ trans('messages.admin_question_id') }} <i class="fa fa-angle-right"></i> {! question.current_question.id !}
        </span>
        <span class="pull-right" >
            <form class="form-inline preview-tools">
                <div class="form-group">
                    <div class="btn-nav-group">
                        <a href="" ng-click="question.getQuestionByIndex(futureed.BACK)" class="btn-nav" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_previous_question') }}" data-placement="left"><</a><a href="" ng-click="question.getQuestionByIndex(futureed.NEXT)" class="btn-nav" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_next_question') }}" data-placement="right">></a>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <i class="fa fa-search" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_jump_to_question_no') }}" data-placement="left"></i>
                    </label>
                    <select class="form-control" ng-model="question.question_index" ng-change="question.getQuestionByIndex()">
                        <option ng-repeat="(key, q) in question.question_list" value="{! key !}">{! key + 1 !}</option>
                    </select>
                </div>
            </form>
        </span>
    </div>
    <div>
        <div ng-if="question.question_preview_end && question.question_preview_ok">
            <p class="alert bg-success futureed-color preview-note">
                {{ trans('messages.admin_note_end_module_preview') }}
                <a href="" data-dismiss="modal"><i class="fa fa-long-arrow-left"></i> {{ trans('messages.admin_return_module_list') }}</a>
            </p>
        </div>

        <div ng-if="question.question_preview_ok && question.question_preview_end == futureed.FALSE">
            <p class="alert bg-info futureed-color pull-left">
                {{ trans('messages.admin_note_module_question_preview_only') }}
            </p>

            {{--Correct Answer--}}
            <?php
                $toggleAnswerExplanation = '&middot; <a href="#" data-toggle="collapse" data-target="#answer-explanations"><span  tooltip-directive data-toggle="tooltip" data-placement="left" title="' . trans('messages.admin_show_answer_explanations') . '"><i class="fa fa-question-circle"></i> ' . trans('messages.admin_show_tips') . '</span></a>';
            ?>
            <div ng-if="question.current_question.question_answer != futureed.FALSE">
                <h4 ng-show="question.current_question.question_type != futureed.MULTIPLECHOICE
                && question.current_question.question_type != futureed.GRAPH
                && question.current_question.question_type != futureed.QUADRANT
                && question.current_question.question_type != futureed.PROVIDE
                && question.current_question.question_type != futureed.FILLINBLANK" class="question-correct-answer">
                    <span class="correct-answer-text">{! question.current_question.question_answer !}</span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                    <?php echo $toggleAnswerExplanation; ?>
                </h4>

                {{--provide N--}}  {{--FILL IN BLANK FIB--}}
                <div class="h4 question-correct-answer" ng-if="question.current_question.question_type == futureed.PROVIDE
                    || question.current_question.question_type == futureed.FILLINBLANK">
                    <span class="correct-answer-text">{! question.parseJSONAnswer(question.current_question.question_answer) !}</span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                    <?php echo $toggleAnswerExplanation; ?>
                </div>

                <div ng-show="question.current_question.question_type == futureed.MULTIPLECHOICE">
                    <h4 class="question-correct-answer">
                        <span class="correct-answer-text">
                            <small ng-if="question.current_question.question_answer.answer_image != futureed.NONE ">
                                <a href="#" popover-directive  data-toggle="popover"
                                   data-html="true" data-placement="bottom" trigger="focus"
                                   data-content="<img src='{! question.current_question.question_answer.answer_image !}' width='200' />">
                                    {{ trans('messages.admin_view_image') }}
                                </a></small><span ng-if="question.current_question.question_answer.answer_text != futureed.FALSE">{! question.current_question.question_answer.answer_text !}</span></span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                        <?php echo $toggleAnswerExplanation; ?>
                    </h4>
                </div>

                <div ng-if="question.current_question.question_type == futureed.GRAPH">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 pull-right">
                        <h4 class="question-correct-answer">
                            <span class="correct-answer-text">
                                <a href="" data-toggle="collapse" data-target="#correct_graph">{{ trans('messages.admin_toggle_graph') }}</a>
                            </span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                            <?php echo $toggleAnswerExplanation; ?>
                        </h4>
                        <div id="correct_graph" class="collapse">
                            {{--Horizontal Correct Graph--}}
                            <table class="table" ng-if="question.question_graph_content.orientation == futureed.HORIZONTAL">
                                <tr ng-repeat="(key, item) in question.question_graph_content.image" class="{! item.field !}">
                                    <th class="origin-container" ng-init="question.initDrag()">
                                        <div class="origin {! item.field !}">
                                            <img ng-src="{! item.path !}" />
                                        </div>
                                    </th>
                                    <td ng-repeat="ans in question.current_question.question_answer[key]" class="drop first">
                                        <div class="origin {! ans.field !}">
                                            <img src="{! ans.image !}" />
                                        </div>
                                    </td>
                                    <td class="drop disabled" ng-repeat="col in question.current_question.question_answer[key].lack_tds">
                                    </td>
                                </tr>
                            </table>
                            {{--Vertical Correct Graph--}}
                            <table class="table" ng-if="question.question_graph_content.orientation == futureed.VERTICAL">
                                <tr>
                                    <th ng-repeat="(key, item) in question.question_graph_content.image" class="{! item.field !}" ng-init="question.initDrag()">
                                        <div class="origin {! item.field !}">
                                            <img ng-src="{! item.path !}" />
                                        </div>
                                    </th>
                                </tr>
                                <tr ng-repeat="row in question.current_question.question_answer">
                                    <td ng-repeat="(key, item) in row " class="drop disabled">
                                        <div class="origin {! item.field !}" ng-if="!item.isNumber">
                                            <img ng-src="{! item.image !}" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div ng-if="question.current_question.question_type == futureed.QUADRANT">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-6 pull-right">
                        <h4 class="question-correct-answer">
                            <span class="correct-answer-text">
                                <a href="" data-toggle="collapse" data-target="#quadrant">{{ trans('messages.admin_toggle_graph') }}</a>
                            </span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                            <?php echo $toggleAnswerExplanation; ?>
                        </h4>
                        <div id="quadrant" class="collapse">
                            <div id="quadrant-answer" style="width:300px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>

                <div id="answer-explanations" class="collapse col-md-12 m-top-50">
                    <div class="col-xs-8 col-xs-offset-2">
                        <ul class="nav nav-tabs">
                            <li class="disabled">
                                <a data-toggle="tab" href="#">
                                    {{ trans('messages.answer_explanations') }}
                                    <span class="badge">
                                        {! question.answer_explanation_count !} of {! question.answer_explanations.records.length !}
                                    </span>
                                </a>
                            </li>
                            <li class="active"><a data-toggle="tab" href="#default-ans-exp">{{ trans('messages.admin_default') }}</a></li>
                            <li><a data-toggle="tab" href="#with-avatar-ans-exp">{{ trans('messages.admin_with_avatar') }}</a></li>
                            <li class="pull-right">
                                <a href="#" ng-click="mod.getAnswerExplanationByIndex(futureed.BACK)"><i class="fa fa-angle-right"></i></a>
                            </li>
                            <li class="pull-right">
                                <a href="#" ng-click="mod.getAnswerExplanationByIndex(futureed.NEXT)"><i class="fa fa-angle-left"></i></a>
                            </li>
                        </ul>
                        <div class="tab-content" ng-show="question.answer_explanations.records.length > futureed.FALSE">
                            <div id="default-ans-exp" class="tab-pane fade in active">
                                <div class="col-md-12">
                                    <span class="result-message tip-result result-incorrect col-xs-3">
                                        <i class="fa fa-times tip-fa-icon text-center"></i>
                                        <p class="h3">{{ trans('messages.oops') }}</p>
                                    </span>

                                    <div class="result-tip tip-content">
                                        <div class="tip-icon">
                                            <img src="/images/icon-tipbulb.png">
                                        </div>
                                        <div class="tip-message">
                                            <img ng-if="question.answer_explanation.image != futureed.NONE" ng-src="{! question.answer_explanation.image !}">
                                            <p class="h4 m-bottom-0 m-top-20" ng-bind-html="question.answer_explanation.answer_explanation | trustAsHtml"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="proceed-btn-container btn-container">
                                    <button type="button" class="btn btn-maroon btn-medium">
                                        {{ trans('messages.proceed_to_next_questions') }}
                                    </button>
                                </div>
                            </div>
                            <div id="with-avatar-ans-exp" class="tab-pane fade">
                                <div class="message-container m-top-20">
                                    <div class="col-md-12">
                                        <div class="quoted-module-icon-holder col-xs-5">
                                            <p class="quote-message-obtuse">I want you to stretch beyond your comfort zone and master this material</p>
                                            <img class="quoted-avatar" ng-src="/images/avatar/doctor-male/doctor_male-7.png" src="/images/avatar/doctor-male/doctor_male-7.png">
                                        </div>

                                        <div class="col-xs-7">
                                            <div class="tip-result-message result-incorrect">
                                                <span>{{ trans('messages.oops') }}</span>
                                            </div>

                                            <div class="result-tip quoted-tip">
                                                <img ng-if="question.answer_explanation.image != futureed.NONE" ng-src="{! question.answer_explanation.image !}">

                                                <p class="answer-explanation h4 text-left m-top-20" ng-bind-html="question.answer_explanation.answer_explanation | trustAsHtml"></p>
                                            </div>
                                        </div>

                                        <div class="proceed-btn-container btn-container col-md-12">
                                            <button type="button" class="btn btn-maroon btn-medium">
                                                {{ trans('messages.proceed_to_next_questions') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger m-top-20" ng-show="question.answer_explanations.records.length <= futureed.FALSE">
                            {{ trans('messages.admin_no_answer_explanations') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="questions-container col-md-12">
                {{--Header--}}
                <div class="questions-header">
                    <div ng-class="{'col-xs-6':question.current_question.question_type != futureed.CODING,'col-xs-4':question.current_question.question_type == futureed.CODING}">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-gold next-btn" ng-click="question.question.closeQuestionPreview()">
                                {{ trans('messages.exit_module') }}
                            </button>
                        </div>
                        <div class="col-xs-6"
                             ng-if="question.current_question.question_type != futureed.CODING"
                                >
                            <div><h3> {{ trans('messages.question') }} #{! question.question_number !} </h3></div>
                        </div>
                    </div>
                    <div ng-class="{'col-xs-6':question.current_question.question_type != futureed.CODING,'col-xs-8':question.current_question.question_type == futureed.CODING}">
                        <div class="header-progress col-xs-6 bottom-6" ng-if="question.current_question.question_type != futureed.CODING">
                            <h3 class="border-radius-30">{{ trans('messages.progress') }} 0 / 12</h3>
                        </div>
                        <div class="header-progress col-xs-6 bottom-6" ng-if="question.current_question.question_type == futureed.CODING">
                            <h3 class="border-radius-30">{! question.current_question.questions_text !}</h3>
                        </div>
                        <div class="col-xs-6">
                            <button ng-if="!question.result.answered && !question.result.quoted && !question.result.failed && question.current_question.question_type != futureed.CODING"
                                    type="button"
                                    class="btn btn-orange next-btn"
                                    ng-click="question.getQuestionByIndex(futureed.NEXT)"> {{ trans('messages.submit') }} </button>
                            <!-- <button type="button"
                                    ng-if="question.current_question.question_type == futureed.CODING"
                                    class="btn btn-orange next-btn right-0 btn-code-run"
                                    ng-click="question.runCode();"> {{ trans('messages.run') }} </button> -->
                        </div>
                    </div>
                </div>
                {{--Contents--}}
                <div class="question-contents">
                    {{--Snap Table loading--}}
                    <div class="col-md-12"
                         id="loading"
                         ng-if="question.current_question.question_type == futureed.CODING"
                         style="margin-top:40px;"
                            >
                        <center>
                            <h1>{{ trans('messages.loading') }}</h1>
                        {{--</center>--}}
                    </div>
                    {{--Main Question Contents--}}
                    <div class="col-xs-6"
                         ng-if="question.current_question.question_type != futureed.CODING"
                            >
                        {{--Image--}}
                        <div class="col-md-12">
                            <div class="questions-image">
                                <img ng-if="question.current_question.questions_image != futureed.NONE " ng-src="{! question.current_question.questions_image !}"/>
                            </div>
                        </div>
                        {{--Message--}}
                        <div class="col-md-12">
                            <div class="questions-message">
                                <p ng-bind-html="question.current_question.questions_text | trustAsHtml"></p>
                            </div>
                        </div>
                        {{--Tips--}}
                        <div class="col-md-12">
                            <div class="questions-tips text-center"
                                 ng-class="{'question-tip-pos-top-10' : question.current_question.questions_image != futureed.NONE, 'question-tip-pos-top-130' : question.current_question.questions_image == futureed.NONE}"
                                 ng-if="question.current_question.question_type == futureed.ORDERING">
                                {{ trans('messages.drag_items_reorder') }}
                            </div>
                        </div>

                    </div>
                    {{--Answers--}}
                    <div class="col-xs-6"
                         ng-if="question.current_question.question_type != futureed.CODING"
                            >
                        <div class="questions-answers">
                            {{--question.current_question.question_type == futureed.MULTIPLECHOICE--}}
                            <div class="margin-top-30">
                                <a ng-if="question.current_question.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in question.current_question.question_answers"
                                   ng-click="question.selectAnswer(choices)" ng-class="{ 'selected-choice' : question.current_question.answer_id == choices.id }">
                                    <div ng-if="choices.answer_text != '' ">{! choices.answer_text !}</div>
                                    <img ng-if="choices.answer_image != futureed.NONE " ng-src="{! choices.answer_image !}" />
                                </a>
                            </div>
                            {{--question.current_question.question_type == futureed.FILLINBLANK--}}
                            <div class="margin-top-30">
                                <div ng-if="question.current_question.question_type == futureed.FILLINBLANK" class="form-group">
                                    <div ng-class="{ 'fib-text-fields' : question.current_question.answer_text_field_count.length > 1 }">
                                        <input ng-repeat="n in question.current_question.answer_text_field_count track by $index"
                                               ng-moduleel="question.current_question.answer_text[n]"
                                               name="answer_text"
                                               type="text" class="form-control question-text-answer form-control-lg"
                                               placeholder="Answer {! (question.current_question.answer_text_field_count.length > 1) ? $index + 1 : '' !}"
                                                />
                                    </div>
                                </div>
                            </div>
                            {{--question.current_question.question_type == futureed.PROVIDE--}}
                            <div class="margin-top-30">
                                <div ng-if="question.current_question.question_type == futureed.PROVIDE" class="form-group">
                                    <input ng-model="question.current_question.answer_text"
                                           name="answer_text"
                                           type="text"
                                           class="form-control question-text-answer form-control-lg" placeholder="Answer"/>
                                </div>
                            </div>
                            {{--question.current_question.question_type == futureed.ORDERING--}}
                            <div class="margin-top-30">
                                <div ng-if="question.current_question.question_type == futureed.ORDERING">
                                    <ul as-sortable="question.dragControlListeners" ng-model="question.current_question.answer_text">
                                        <li ng-repeat="item in question.current_question.answer_text track by item.key" as-sortable-item class="as-sortable-item">
                                            <div as-sortable-item-handle class="as-sortable-item-handle">
                                                <span data-ng-bind="item.value"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{--question.current_question.question_type == futureed.GRAPH--}}
                            <div class="margin-top-30">
                                <div ng-if="question.current_question.question_type == futureed.GRAPH">
                                    <div>
                                        {{--Horizontal--}}
                                        <table id="horizontalTable" class="table" ng-if="question.question_graph_content.orientation == futureed.HORIZONTAL">
                                            <tr ng-repeat="item in question.question_graph_content.image" class="{! item.field !}">
                                                <th class="origin-container" ng-init="question.initDrag()">
                                                    <div class="origin {! item.field !}">
                                                        <img ng-src="{! item.path !}" />
                                                    </div>
                                                </th>
                                                <td ng-init="question.initDrop()" class="drop first">
                                                </td>
                                                <td ng-init="question.initDrop()" class="drop disabled" ng-repeat="col in question.graph_layout" ng-if="$index > 0">
                                                </td>
                                            </tr>
                                        </table>
                                        {{--Vertical--}}
                                        <table id="verticalTable" class="table" ng-if="question.question_graph_content.orientation == futureed.VERTICAL">
                                            <tr>
                                                <th ng-repeat="item in question.question_graph_content.image" class="{! item.field !}" ng-init="question.initDrag()">
                                                    <div class="origin {! item.field !}">
                                                        <img ng-src="{! item.path !}" />
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td ng-repeat="item in question.question_graph_content.image" ng-init="question.initDrop()" class="drop first">
                                                </td>
                                            </tr>
                                            <tr ng-repeat="col in question.graph_layout" ng-if="$index > 0">
                                                <td ng-repeat="item in question.question_graph_content.image" ng-init="question.initDrop()" class="drop disabled">
                                                </td>
                                            </tr>

                                        </table>
                                        <div class="col-xs-3 pull-right reset-graph">
                                            <button class="btn btn-gold" ng-click="question.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--question.current_question.question_type == futureed.QUADRANT--}}
                            <div class="margin-top-30">
                                <div ng-if="question.current_question.question_type == futureed.QUADRANT">
                                    <div>
                                        <div id="placeholder" style="width:300px;height:300px;margin:0 auto;"></div>
                                        <div class="col-xs-3 pull-right reset-graph">
                                            <button class="btn btn-gold" ng-click="question.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Snap--}}
                    <div class="col-md-12"
                         id="snap_container"
                         ng-if="question.current_question.question_type == futureed.CODING"
                            >
                        <center>
                            <div class="content" id="world_container">
                                <canvas id="world" tabindex="1"
                                        style=" border-left: 5px solid #fff;
                                                border-right: 5px solid #fff;
                                        "
                                        >
                                    <p>{{ trans('messages.canvas_not_supported') }}</p>
                                </canvas>
                            </div>
                        </center>
                    </div>
                    <div ng-init="question.set_IDE();" ng-if="question.current_question.question_type == futureed.CODING"></div>
                </div>
            </div>
        </div>

        <div ng-if="question.question_no_preview == futureed.TRUE" class="modal-body">
            <p class="alert alert-warning">
                {{ trans('messages.admin_note_module_preview_cant_load_no_questions_available') }}
            </p>
        </div>
    </div>




    {{--body--}}

    {{--footer--}}
</div>

{{--modal--}}
<div id="questions_preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <div class="pull-right">
                {!! Form::button(trans('messages.back')
                    , array(
                        'class' => 'btn btn-blue col-md-1'
                        , 'data-dismiss' => 'modal'
                        , 'ng-click' => 'module.closeQuestionPreview()'
                    )
                ) !!}
            </div>
            <div class="h4">
                {! module.module_name !} {{ trans('messages.admin_preview') }}
                <small ng-if="module.question_preview_ok && module.question_preview_end == futureed.FALSE">
                    <i class="fa fa-angle-right"></i> {{ trans('messages.admin_question_id') }} <i class="fa fa-angle-right"></i> {! module.current_question.id !}
                </small>

                <span class="pull-right" ng-if="module.question_preview_ok">
                    <form class="form-inline preview-tools">
                        <div class="form-group">
                            <div class="btn-nav-group">
                                <a href="" ng-click="module.getQuestionByIndex(futureed.BACK)" class="btn-nav" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_previous_question') }}" data-placement="left"><</a><a href="" ng-click="module.getQuestionByIndex(futureed.NEXT)" class="btn-nav" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_next_question') }}" data-placement="right">></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <i class="fa fa-search" tooltip-directive data-toggle="tooltip" title="{{ trans('messages.admin_jump_to_question_no') }}" data-placement="left"></i>
                            </label>
                            <select class="form-control" ng-model="module.question_index" ng-change="module.getQuestionByIndex()">
                                <option ng-repeat="(key, q) in module.question_list" value="{! key !}">{! key + 1 !}</option>
                            </select>
                        </div>
                    </form>
                </span>
            </div>
        </div>
        <div ng-if="module.question_preview_end && module.question_preview_ok" class="modal-body">
            <p class="alert bg-success futureed-color preview-note">
                {{ trans('messages.admin_note_end_module_preview') }}
                <a href="" data-dismiss="modal"><i class="fa fa-long-arrow-left"></i> {{ trans('messages.admin_return_module_list') }}</a>
            </p>
        </div>

        <div ng-if="module.question_preview_ok && module.question_preview_end == futureed.FALSE" class="modal-body">
            <p class="alert bg-info futureed-color pull-left">
                {{ trans('messages.admin_note_module_question_preview_only') }}
            </p>

            Correct Answer
            <?php
                $toggleAnswerExplanation = '&middot; <a href="#" data-toggle="collapse" data-target="#answer-explanations"><span  tooltip-directive data-toggle="tooltip" data-placement="left" title="' . trans('messages.admin_show_answer_explanations') . '"><i class="fa fa-question-circle"></i> ' . trans('messages.admin_show_tips') . '</span></a>';
            ?>
            <div ng-if="module.current_question.question_answer != futureed.FALSE">
                <h4 ng-show="module.current_question.question_type != futureed.MULTIPLECHOICE && module.current_question.question_type != futureed.GRAPH && module.current_question.question_type != futureed.QUADRANT" class="question-correct-answer">
                    <span class="correct-answer-text">{! module.current_question.question_answer !}</span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                    <?php echo $toggleAnswerExplanation; ?>
                </h4>
                <div ng-show="module.current_question.question_type == futureed.MULTIPLECHOICE">
                    <h4 class="question-correct-answer">
                        <span class="correct-answer-text">
                            <small ng-if="module.current_question.question_answer.answer_image != futureed.NONE ">
                                <a href="#" popover-directive  data-toggle="popover"
                                    data-html="true" data-placement="bottom" trigger="focus"
                                    data-content="<img src='{! module.current_question.question_answer.answer_image !}' width='200' />">
                                    {{ trans('messages.admin_view_image') }}
                                </a></small><span ng-if="module.current_question.question_answer.answer_text != futureed.FALSE">{! module.current_question.question_answer.answer_text !}</span></span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                                <?php echo $toggleAnswerExplanation; ?>
                    </h4>
                </div>

                <div ng-if="module.current_question.question_type == futureed.GRAPH">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-6 pull-right">
                        <h4 class="question-correct-answer">
                            <span class="correct-answer-text">
                                <a href="" data-toggle="collapse" data-target="#correct_graph">{{ trans('messages.admin_toggle_graph') }}</a>
                            </span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                            <?php echo $toggleAnswerExplanation; ?>
                        </h4>
                        <div id="correct_graph" class="collapse">
                            Horizontal Correct Graph
                            <table class="table" ng-if="module.question_graph_content.orientation == futureed.HORIZONTAL">
                                <tr ng-repeat="(key, item) in module.question_graph_content.image" class="{! item.field !}">
                                    <th class="origin-container" ng-init="module.initDrag()">
                                        <div class="origin {! item.field !}">
                                            <img ng-src="{! item.path !}" />
                                        </div>
                                    </th>
                                    <td ng-repeat="ans in module.current_question.question_answer[key]" class="drop first">
                                        <div class="origin {! ans.field !}">
                                            <img src="{! ans.image !}" />
                                        </div>
                                    </td>
                                    <td class="drop disabled" ng-repeat="col in module.current_question.question_answer[key].lack_tds">
                                    </td>
                                </tr>
                            </table>
                            Vertical Correct Graph
                            <table class="table" ng-if="module.question_graph_content.orientation == futureed.VERTICAL">
                                <tr>
                                    <th ng-repeat="(key, item) in module.question_graph_content.image" class="{! item.field !}" ng-init="module.initDrag()">
                                        <div class="origin {! item.field !}">
                                            <img ng-src="{! item.path !}" />
                                        </div>
                                    </th>
                                </tr>
                                <tr ng-repeat="row in module.current_question.question_answer">
                                    <td ng-repeat="(key, item) in row " class="drop disabled">
                                        <div class="origin {! item.field !}" ng-if="!item.isNumber">
                                            <img ng-src="{! item.image !}" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div ng-if="module.current_question.question_type == futureed.QUADRANT">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-6 pull-right">
                        <h4 class="question-correct-answer">
                            <span class="correct-answer-text">
                                <a href="" data-toggle="collapse" data-target="#quadrant">{{ trans('messages.admin_toggle_graph') }}</a>
                            </span> <i class="fa fa-angle-left"></i> {{ trans('messages.admin_correct_answer') }}
                            <?php echo $toggleAnswerExplanation; ?>
                        </h4>
                        <div id="quadrant" class="collapse">
                            <div id="quadrant-answer" style="width:300px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>

                <div id="answer-explanations" class="collapse col-xs-12 m-top-50">
                    <div class="col-xs-8 col-xs-offset-2">
                        <ul class="nav nav-tabs">
                            <li class="disabled">
                                <a data-toggle="tab" href="#">
                                    {{ trans('messages.answer_explanations') }}
                                    <span class="badge">
                                        {! module.answer_explanation_count !} of {! module.answer_explanations.records.length !}
                                    </span>
                                </a>
                            </li>
                            <li class="active"><a data-toggle="tab" href="#default-ans-exp">{{ trans('messages.admin_default') }}</a></li>
                            <li><a data-toggle="tab" href="#with-avatar-ans-exp">{{ trans('messages.admin_with_avatar') }}</a></li>
                            <li class="pull-right">
                                <a href="#" ng-click="mod.getAnswerExplanationByIndex(futureed.BACK)"><i class="fa fa-angle-right"></i></a>
                            </li>
                            <li class="pull-right">
                                <a href="#" ng-click="mod.getAnswerExplanationByIndex(futureed.NEXT)"><i class="fa fa-angle-left"></i></a>
                            </li>
                        </ul>
                        <div class="tab-content" ng-show="module.answer_explanations.records.length > futureed.FALSE">
                            <div id="default-ans-exp" class="tab-pane fade in active">
                                <div class="col-xs-12">
                                    <span class="result-message tip-result result-incorrect col-xs-3">
                                        <i class="fa fa-times tip-fa-icon text-center"></i>
                                        <p class="h3">{{ trans('messages.oops') }}</p>
                                    </span>

                                    <div class="result-tip tip-content">
                                        <div class="tip-icon">
                                            <img src="/images/icon-tipbulb.png">
                                        </div>
                                        <div class="tip-message">
                                            <img ng-if="module.answer_explanation.image != futureed.NONE" ng-src="{! module.answer_explanation.image !}">
                                            <p class="h4 m-bottom-0 m-top-20" ng-bind-html="module.answer_explanation.answer_explanation | trustAsHtml"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="proceed-btn-container btn-container">
                                    <button type="button" class="btn btn-maroon btn-medium">
                                        {{ trans('messages.proceed_to_next_questions') }}
                                    </button>
                                </div>
                            </div>
                            <div id="with-avatar-ans-exp" class="tab-pane fade">
                                <div class="message-container m-top-20">
                                    <div class="col-xs-12">
                                        <div class="quoted-module-icon-holder col-xs-5">
                                            <p class="quote-message-obtuse">I want you to stretch beyond your comfort zone and master this material</p>
                                            <img class="quoted-avatar" ng-src="/images/avatar/doctor-male/doctor_male-7.png" src="/images/avatar/doctor-male/doctor_male-7.png">
                                        </div>

                                        <div class="col-xs-7">
                                            <div class="tip-result-message result-incorrect">
                                                <span>{{ trans('messages.oops') }}</span>
                                            </div>

                                            <div class="result-tip quoted-tip">
                                                <img ng-if="module.answer_explanation.image != futureed.NONE" ng-src="{! module.answer_explanation.image !}">

                                                <p class="answer-explanation h4 text-left m-top-20" ng-bind-html="module.answer_explanation.answer_explanation | trustAsHtml"></p>
                                            </div>
                                        </div>

                                        <div class="proceed-btn-container btn-container col-xs-12">
                                            <button type="button" class="btn btn-maroon btn-medium">
                                                {{ trans('messages.proceed_to_next_questions') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger m-top-20" ng-show="module.answer_explanations.records.length <= futureed.FALSE">
                            {{ trans('messages.admin_no_answer_explanations') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="questions-container col-xs-12 col-md-12">
                Header
                <div class="questions-header">
                    <div ng-class="{'col-xs-6':module.current_question.question_type != futureed.CODING,'col-xs-4':module.current_question.question_type == futureed.CODING}">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-gold next-btn" ng-click="module.module.closeQuestionPreview()">
                                {{ trans('messages.exit_module') }}
                            </button>
                        </div>
                        <div class="col-xs-6"
                             ng-if="module.current_question.question_type != futureed.CODING"
                        >
                            <div><h3> {{ trans('messages.question') }} #{! module.question_number !} </h3></div>
                        </div>
                    </div>
                    <div ng-class="{'col-xs-6':module.current_question.question_type != futureed.CODING,'col-xs-8':module.current_question.question_type == futureed.CODING}">
                        <div class="header-progress col-xs-6 bottom-6" ng-if="module.current_question.question_type != futureed.CODING">
                            <h3 class="border-radius-30">{{ trans('messages.progress') }} 0 / 12</h3>
                        </div>
                        <div class="header-progress col-xs-6 bottom-6" ng-if="module.current_question.question_type == futureed.CODING">
                            <h3 class="border-radius-30">{! module.current_question.questions_text !}</h3>
                        </div>
                        <div class="col-xs-6">
                            <button ng-if="!module.result.answered && !module.result.quoted && !module.result.failed && module.current_question.question_type != futureed.CODING"
                                    type="button"
                                    class="btn btn-orange next-btn"
                                    ng-click="module.getQuestionByIndex(futureed.NEXT)"> {{ trans('messages.submit') }} </button>
                            <!-- <button type="button"
                                    ng-if="module.current_question.question_type == futureed.CODING"
                                    class="btn btn-orange next-btn right-0 btn-code-run"
                                    ng-click="module.runCode();"> {{ trans('messages.run') }} </button> -->
                        </div>
                    </div>
                </div>
                Contents
                <div class="question-contents">
                    Snap Table loading
                    <div class="col-xs-12"
                         id="loading"
                         ng-if="module.current_question.question_type == futureed.CODING"
                         style="margin-top:40px;"
                    >
                        <center>
                            <h1>{{ trans('messages.loading') }}</h1>
                        </center>
                    </div>
                    Main Question Contents
                    <div class="col-xs-6"
                         ng-if="module.current_question.question_type != futureed.CODING"
                    >
                        Image
                        <div class="col-xs-12">
                            <div class="questions-image">
                                <img ng-if="module.current_question.questions_image != futureed.NONE " ng-src="{! module.current_question.questions_image !}"/>
                            </div>
                        </div>
                        Message
                        <div class="col-xs-12">
                            <div class="questions-message">
                                <p ng-bind-html="module.current_question.questions_text | trustAsHtml"></p>
                            </div>
                        </div>
                        Tips
                        <div class="col-xs-12">
                            <div class="questions-tips text-center"
                                 ng-class="{'question-tip-pos-top-10' : module.current_question.questions_image != futureed.NONE, 'question-tip-pos-top-130' : module.current_question.questions_image == futureed.NONE}"
                                 ng-if="module.current_question.question_type == futureed.ORDERING">
                                {{ trans('messages.drag_items_reorder') }}
                            </div>
                        </div>

                    </div>
                    Answers
                    <div class="col-xs-6"
                         ng-if="module.current_question.question_type != futureed.CODING"
                    >
                        <div class="questions-answers">
                            module.current_question.question_type == futureed.MULTIPLECHOICE
                            <div class="margin-top-30">
                                <a ng-if="module.current_question.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in module.current_question.question_answers"
                                    ng-click="module.selectAnswer(choices)" ng-class="{ 'selected-choice' : module.current_question.answer_id == choices.id }">
                                    <div ng-if="choices.answer_text != '' ">{! choices.answer_text !}</div>
                                    <img ng-if="choices.answer_image != futureed.NONE " ng-src="{! choices.answer_image !}" />
                                </a>
                            </div>
                            module.current_question.question_type == futureed.FILLINBLANK
                            <div class="margin-top-30">
                                <div ng-if="module.current_question.question_type == futureed.FILLINBLANK" class="form-group">
                                    <div ng-class="{ 'fib-text-fields' : module.current_question.answer_text_field_count.length > 1 }">
                                        <input ng-repeat="n in module.current_question.answer_text_field_count track by $index"
                                               ng-moduleel="module.current_question.answer_text[n]"
                                               name="answer_text"
                                               type="text" class="form-control question-text-answer form-control-lg"
                                               placeholder="Answer {! (module.current_question.answer_text_field_count.length > 1) ? $index + 1 : '' !}"
                                        />
                                    </div>
                                </div>
                            </div>
                            module.current_question.question_type == futureed.PROVIDE
                            <div class="margin-top-30">
                                <div ng-if="module.current_question.question_type == futureed.PROVIDE" class="form-group">
                                <input ng-model="module.current_question.answer_text"
                                       name="answer_text"
                                       type="text"
                                       class="form-control question-text-answer form-control-lg" placeholder="Answer"/>
                                </div>
                            </div>
                            module.current_question.question_type == futureed.ORDERING
                            <div class="margin-top-30">
                                <div ng-if="module.current_question.question_type == futureed.ORDERING">
                                    <ul as-sortable="module.dragControlListeners" ng-model="module.current_question.answer_text">
                                        <li ng-repeat="item in module.current_question.answer_text track by item.key" as-sortable-item class="as-sortable-item">
                                            <div as-sortable-item-handle class="as-sortable-item-handle">
                                                <span data-ng-bind="item.value"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            module.current_question.question_type == futureed.GRAPH
                            <div class="margin-top-30">
                                <div ng-if="module.current_question.question_type == futureed.GRAPH">
                                    <div>
                                        Horizontal
                                        <table id="horizontalTable" class="table" ng-if="module.question_graph_content.orientation == futureed.HORIZONTAL">
                                            <tr ng-repeat="item in module.question_graph_content.image" class="{! item.field !}">
                                                <th class="origin-container" ng-init="module.initDrag()">
                                                    <div class="origin {! item.field !}">
                                                        <img ng-src="{! item.path !}" />
                                                    </div>
                                                </th>
                                                <td ng-init="module.initDrop()" class="drop first">
                                                </td>
                                                <td ng-init="module.initDrop()" class="drop disabled" ng-repeat="col in module.graph_layout" ng-if="$index > 0">
                                                </td>
                                            </tr>
                                        </table>
                                        Vertical
                                        <table id="verticalTable" class="table" ng-if="module.question_graph_content.orientation == futureed.VERTICAL">
                                            <tr>
                                                <th ng-repeat="item in module.question_graph_content.image" class="{! item.field !}" ng-init="module.initDrag()">
                                                    <div class="origin {! item.field !}">
                                                        <img ng-src="{! item.path !}" />
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td ng-repeat="item in module.question_graph_content.image" ng-init="module.initDrop()" class="drop first">
                                                </td>
                                            </tr>
                                            <tr ng-repeat="col in module.graph_layout" ng-if="$index > 0">
                                                <td ng-repeat="item in module.question_graph_content.image" ng-init="module.initDrop()" class="drop disabled">
                                                </td>
                                            </tr>

                                        </table>
                                        <div class="col-xs-3 pull-right reset-graph">
                                            <button class="btn btn-gold" ng-click="module.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            module.current_question.question_type == futureed.QUADRANT
                            <div class="margin-top-30">
                                <div ng-if="module.current_question.question_type == futureed.QUADRANT">
                                    <div>
                                        <div id="placeholder" style="width:300px;height:300px;margin:0 auto;"></div>
                                        <div class="col-xs-3 pull-right reset-graph">
                                            <button class="btn btn-gold" ng-click="module.resetGraph()">{{ trans('messages.reset_caps') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    Snap
                    <div class="col-xs-12"
                         id="snap_container"
                         ng-if="module.current_question.question_type == futureed.CODING"
                    >
                        <center>
                            <div class="content" id="world_container">
                                <canvas id="world" tabindex="1"
                                        style=" border-left: 5px solid #fff;
                                                border-right: 5px solid #fff;
                                        "
                                >
                                    <p>{{ trans('messages.canvas_not_supported') }}</p>
                                </canvas>
                            </div>
                        </center>
                    </div>
                    <div ng-init="module.set_IDE();" ng-if="module.current_question.question_type == futureed.CODING"></div>
                </div>
            </div>
        </div>

        <div ng-if="!module.question_preview_ok" class="modal-body">
            <p class="alert alert-warning">
                {{ trans('messages.admin_note_module_preview_cant_load_no_questions_available') }}
            </p>
        </div>

        <!-- <div class="modal-footer"></div> -->
    </div>
  </div>
</div>

