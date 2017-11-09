<div>
    <div style="visibility:hidden">
        <input type="text" name="randomDigits1" id="randomDigits1" required autofocus value="4">
        <input type="text" name="randomDigits2" id="randomDigits2" readonly><br><br>
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div>
        <!--  dynamic questions area -->
        <div id="questionPane" class="col-xs-6 answer_area">
            <div id="start_div" class="m-top-20 h4" style="display: none;">
                <p ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
                {{-- <label>What is the place value of the underlined integer? <b id="str_interger_b"></b>.<b id="str_decimal_b"></b></label>
                <br><br><br><input type="button" onclick="startBtnOnclick()" value="Start">--}}
            </div>
        </div>
        <!--  answer area -->
        <div id="step_div" class="col-xs-6 pull-right h4 integer_area">
            <div id="tableNumber_div"></div>
            <div id="lastDiv"></div>
        </div>

        <!-- tips area -->
        <div id="tipsFlow" class="integer_area" style="display: none;">
           <div class="prof-info h3"><img src="/images/icon-tipbulb.png"><b> Tips</b></div>
           <div id="ansFlow" style="display: none;" class="col-xs-6 h4">
               <div class="pull-right answer_area">
                   <div class="prof-info"><b>Answered Flow</b></div><br/>
                    <div id="correct_flow"></div><br>
               </div>
           </div>
           <div id="ansCorrectFlow" style="display: none;" class="col-xs-6 h4">
               <div class="pull-left answer_area">
                   <div class="prof-info"><b>Correct Answer Flow</b></div><br/>
                    <div id="correct_flow_answer"></div><br>
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
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="closeModal();dynamicUnBlock();" style="display: none;">Close</button>
            </div>
        </div>
    </div>
    {!! Html::script('/js/common/operations/global.js?20170806' . '?size=' . File::size(public_path('/js/common/operations/global.js')))!!}
    {!! Html::script('/js/common/operations/integer_decimal.js' . '?size=' . File::size(public_path('/js/common/operations/integer_decimal.js')))!!}
</div>