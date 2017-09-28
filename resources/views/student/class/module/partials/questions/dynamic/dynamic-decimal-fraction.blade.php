<div>
    <div style="visibility:hidden">
        <input type="text" class="input_num_max" style="width: 50px" readonly>
        <input type="text" name="randomDigits" id="randomDigits" required autofocus value="4">
        <input type="text" name="randomNumber1" id="randomNumber1" readonly>
        <input type="text" name="randomNumber2" id="randomNumber2" readonly><br><br>
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div id="start_div" style="display:none;">
        <!-- questions area -->
        <div id="questionPane">
            <p class="col-xs-6 h3" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
        </div>

        <!-- answer area -->
        <div id="step_div" class="col-xs-6 pull-right h4 answer_area">
            <div id="tableNumber_div" class="margin-10-top margin-10-bot h4"></div>
            <div id="lastDiv" class="margin-10-top margin-10-bot h4"></div>
        </div>

        <!-- tips area -->
        <div id="tipsFlow" style="display: none;">
            <div class="prof-info h3"><img src="/images/icon-tipbulb.png"><b> Tips</b></div>
            <div id="ansFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-right">
                    <div class="prof-info"><b>Answered Flow</b></div><br/>
                    <div id="correct_flow"></div><br>
                </div>
            </div>
            <div id="ansCorrectFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-left">
                    <div class="prof-info"><b>Correct Answer Flow</b></div><br/>
                    <div id="correct_flow_answer"></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    {{--modal--}}
    <div id="message_modal_dynamic" class="modal">

        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                {{--<span class="close" onclick="btnNOOnclose()">&times;</span>--}}
                <h2>Question</h2>
            </div>
            <div class="modal-body">
                <div id="message_text_modal" class="h4"></div>

                <br><br>
                <div id="num1_1div"></div>
                <div id="num2_1div"></div>
            </div>
            <div class="modal-footer">
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal"
                        onclick="closeModal();dynamicUnBlock()" style="display: none;">Close</button>
                <button id="close_back_modal" type="button" class="btn btn-gold btn-medium pull-right"
                        onclick="simplifyPossible();" style="display: none;">{!! trans('messages.ok') !!}</button>
                <button id="can_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal"
                        onclick="canbtnYEsOnclick();dynamicUnBlock()" style="display: none;">{!! trans('messages.yes') !!}</button>
                <button id="yes_modal" type="button" class="btn btn-green btn-medium pull-left" data-dismiss="modal" onclick="btnYEsOnclick();dynamicUnBlock()">
                    {!! trans('messages.yes') !!}
                </button>
                <button id="no_modal" type="button" class="btn btn-gold btn-medium pull-right" onclick="btnNOOnclick();">
                    {!! trans('messages.no') !!}
                </button>
            </div>
        </div>

    </div>
    {!! Html::script('/js/common/operations/decimal_fraction.js')!!}
    {!! Html::script('/js/common/operations/global.js')!!}

</div>
