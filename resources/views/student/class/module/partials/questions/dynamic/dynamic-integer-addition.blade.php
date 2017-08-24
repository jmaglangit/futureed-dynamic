<div>
    <!-- this div -->
    <div style="visibility:hidden">
        <label>randomNumberDigits:</label>
        <input type="text" class="randomNumberDigits1" readonly>
        <input type="text" class="randomNumberDigits2" readonly><br><br>
        <label>randomWordsDigits :</label>
        <input type="text" class="randomWordsDigits1" style="width: 50px">
        <input type="text" class="randomWordsDigits2" style="width: 50px">
        <input type="button" value="GEN" onclick="randomDigitsOnclick()">
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>
    <div>
        <!-- dynamic questions area -->
        <div id="questionPane" class="col-xs-6 answer_area">
          <p class="m-top-20 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
            <div id="start_div" style="display: none;" class="h4">
              <p>What is the value of <b id="firstNumber_b">200</b> 
              <label id="firstDigits_label"></label> and <b id="secondNumber_b">2</b> 
              <label id="secondDigits_label"></label>?</p>
            </div>
        </div>
        <!-- #end questions area -->

        <!-- answer area on right side -->
        <div id="step_div" class="col-xs-6 pull-right h4 int_add_adjust">
            <br><br><br>
            <div id="first_div"></div>
            <div id="second_div"></div>
            <div id="add_div"></div>
            <div id="answer_div"></div>
        </div>
        <!-- end answer area -->

        <div id="tipsFlow" style="display: none;">
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
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="btnNOOnclose();" style="display: none;">Close</button>
              </div>
          </div>
      </div>
    {!! Html::script('/js/common/operations/integer_addition.js')!!}
    {!! Html::script('/js/common/operations/global.js') !!}
</div>