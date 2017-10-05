<div>
    <!-- this div -->
    <div style="visibility:hidden">
        <input type="text" name="randomDigits" id="randomDigits" required autofocus value="3">
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div>
        <!-- dynamic questions area -->
        <div id="questionPane" class="col-xs-6 answer_area">
                <p class="m-top-20 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
                <div id="start_div" class="m-top-20 h4" style="display: none;">
                    <span>
                        <label id="baseNumber_l">d</label>
                        <sup id="exponents_sup">9</sup>
                    </span>
                    <br><br><br>
                    {{--<input type="button" onclick="startBtnOnclick()" value="Start">--}}
                </div>
        </div>
        <!-- #end questions area -->

        <!-- answer area on right side -->
        <div id="step_div" class="col-xs-6 pull-right h4 integer_area">
            <div id="base_div"></div>
            <div id="exponents_div"></div>
            <div id="writeequation_div"></div>
            <div id="answer"></div>
        </div>
        <!-- end answer area -->

        <div id="tipsFlow" class="integer_area" style="display: none;">
            <div class="prof-info h3"><img src="/images/icon-tipbulb.png"><b> Tips</b></div>
            <div id="ansFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-right answer_area integer_area">
                    <div class="prof-info"><b>Answered Flow</b></div><br/>
                    <div id="correct_flow"></div><br>
                </div>
            </div>
            <div id="ansCorrectFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-left answer_area integer_area">
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
                <!-- <b>Simplify fraction if possible ? </b> -->
                <div id="message_text_modal" class="h4"></div>
                <br><br>
                <div id="num1_1div"></div>
                <div id="num2_1div"></div>
            </div>
            <div class="modal-footer">
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="closeModal();" style="display: none;">Close</button>
            </div>
        </div>
    </div>

    {!! Html::script('/js/common/operations/exponent.js')!!}
    {!! Html::script('/js/common/operations/global.js') !!}
</div>