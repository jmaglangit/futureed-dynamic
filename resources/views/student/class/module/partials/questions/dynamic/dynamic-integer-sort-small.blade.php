<div>
    <div style="visibility:hidden">
        <input type="text" name="randomDigits" id="randomDigits" required autofocus value="4">
        <input type="text" name="randomNumber" id="randomNumber" readonly><br><br>
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div>
        <!-- questions area -->
        <div id="questionPane" class="col-xs-12 answer_area sort_small">
            <div style="float: left; width: 30%;">
                <p class="m-top-20 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
            </div>
            <!-- answer area -->
            <div style="float: left; width: 70%;">
                <div id="examPane" style="display: none;" class="h4">
                    <div style="float: left; width: 33%;" id="answerPane">
                        <div id="lastDiv1"></div>
                    </div>
                    <div style="float: left; width: 33%;" id="answerTipPane">
                        <span class="boldStr">Answered Flow</span>
                        <div id="lastDiv2"></div><br>
                    </div>
                    <div style="float: left; width: 34%;" id="correctAnswerTipPane">
                        <span class="boldStr">Correct Answer Flow</span>
                        <div id="lastDiv3"></div><br>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
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
    {!! Html::style('/css/futureed-student.css') !!}
    {!! Html::script('/js/common/operations/global.js?20170806')!!}
    {!! Html::script('/js/common/operations/sort_min.js?20170806.js')!!}
</div>