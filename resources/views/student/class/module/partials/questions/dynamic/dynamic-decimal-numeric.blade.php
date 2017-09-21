<div>
    <div style="visibility:hidden">
        <label>randomDigits:</label>
        <input type="text" class="randomDigits1" style="width: 50px"><br><br>
        <label>decimalDigits:</label>
        <input type="text" class="randomDigits2" style="width: 50px">
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div id="questionPane">
        <!-- questions area -->
        <div id="start_div">
            {{--<p class="col-xs-6 h3">Find the sum of <label id="subject_number1_p"></label> + <label id="subject_number2_p"></label></p><br>--}}
            <p class="col-xs-6 h3" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
            {{--<button onclick="startAnswer();">Start Answer</button>--}}
        </div>
    </div>

        <!-- answer area -->
        <div id="step_div" class="col-xs-6 pull-right h4 integer_area">
            <div id="tableNumber_div"></div>
            <div id="lastDiv"></div>
        </div>

        <!-- tips area -->
        <div id="tipsFlow">
            <div class="prof-info h3"><img src="/images/icon-tipbulb.png"><b> Tips</b></div>
            <div id="ansFlow" class="col-xs-6 h4">
                <div class="pull-right integer_area">
                    <div class="prof-info"><b>Answered Flow</b></div><br/>
                    <div id="correct_flow"></div><br>
                </div>
            </div>
            <div id="ansCorrectFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-left integer_area">
                    <div class="prof-info"><b>Correct Answer Flow</b></div><br/>
                    <div id="correct_flow_answer"></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>


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
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="closeModal();dynamicUnBlock()" style="display: none;">Close</button>
                <button id="yes_modal" type="button" class="btn btn-green btn-medium pull-left" data-dismiss="modal" onclick="btnYEsOnclick();dynamicUnBlock()">
                    {!! trans('messages.yes') !!}
                </button>


                <button id="no_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="btnNOOnclick();dynamicUnBlock()">
                    {!! trans('messages.no') !!}
                </button>
            </div>
        </div>

    </div>
    {!! Html::script('/js/common/operations/global.js')!!}
    {!! Html::script('/js/common/operations/decimal_numeric.js')!!}

</div>
