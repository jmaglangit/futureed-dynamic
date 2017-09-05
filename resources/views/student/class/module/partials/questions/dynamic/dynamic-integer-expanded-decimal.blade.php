<div>
    <!-- this div -->
    <div style="visibility:hidden">
        <label>randomDigits:</label>
        <input type="text" class="randomDigits1" style="width: 50px"><br><br>
        <label>decimalDigits:</label>
        <input type="text" class="randomDigits2" style="width: 50px">
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div>
        <!-- dynamic questions area -->
        <div id="questionPane" class="col-xs-6 answer_area">
            <div id="start_div" class="m-top-20 h4" style="display: none;">
                <p ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
                <p><b id="firstNumber_b">200</b>
                    <label id="firstDigits_label"></label> and <b id="secondNumber_b">2</b>
                    <label id="secondDigits_label"></label>?</p>
            </div>
        </div>
        <!-- #end questions area -->

        <!-- answer area on right side -->
        <div id="step_div" class="col-xs-6 pull-right h4 int_add_adjust">
            <div id="tableNumber_div"></div>
            <div id="lastDiv"></div>
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

</div>