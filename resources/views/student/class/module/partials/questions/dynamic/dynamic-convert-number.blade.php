<div>
    <div style="visibility:hidden">
        <input type="text" name="randomDigits" id="randomDigits" required autofocus value="4">
        <input type="text" name="randomNumber" id="randomNumber" readonly><br><br>
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>
    <div>
        <!--  dynamic questions area -->
        <div id="questionPane">
            <div id="start_div" style="display: none;">
                <p class="col-xs-6 m-top-20 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
                {{-- <label>Rewrite the following number into words,<b id="randomNumber_b">1234</b></label>
                <br><br><br><input type="button" onclick="startBtnOnclick()" value="Start">--}}
            </div>
        </div>
        <!--  answer area -->
        <div id="step_div" class="col-xs-6 pull-right h4 answer_area">
            <div id="tableNumber_div">
            </div>
            <div id="position_div">
            </div>
            <div id="map_table_div">
            </div>
            <div id="answer">
            </div>
        </div>

        <!-- tips area -->
        <div id="tipsFlow" class="tips_flow_adjst" style="display: none;">
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
                <button id="close_modal" ty pe="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="btnNOOnclose()" style="display: none;">Close</button>
            </div>
        </div>
    </div>
    {!! Html::script('/js/common/operations/global.js?20170806')!!}
    {!! Html::script('/js/common/operations/convert_number.js')!!}
</div>