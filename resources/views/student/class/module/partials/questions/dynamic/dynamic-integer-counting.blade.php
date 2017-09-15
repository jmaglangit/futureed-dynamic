<div>
    <div style="visibility:hidden">
        <input type="text" name="randomNumber" id="randomNumber" readonly><br><br>
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
    </div>

    <div id="examPane" style="display:none;">
        <!-- questions area -->
        <div id="questionPane">
            <p class="col-xs-6 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
            {{--<button onclick="startAnswer();">Start Answer</button>--}}
        </div>
        <div id="answerPane" class="col-xs-6 pull-right h4">
            <div id="lastDiv1" class="margin-10-top margin-10-bot h4"></div>
        </div>
        <!-- answer area -->
        <div id="tipsFlow" style="display: none;" class="tips_area">
            <div class="prof-info h3"><img src="/images/icon-tipbulb.png"><b> Tips</b></div>
            <div id="ansFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-right">
                    <div class="prof-info"><b>Answered Flow</b></div><br/>
                    <div id="lastDiv2"></div><br>
                </div>
            </div>
            <div id="ansCorrectFlow" style="display: none;" class="col-xs-6 h4">
                <div class="pull-left">
                    <div class="prof-info"><b>Correct Answer Flow</b></div><br/>
                    <div id="lastDiv3"></div>
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

    {!! Html::script('/js/common/operations/integer_global.js')!!}
    {!! Html::script('/js/common/operations/integer_counting.js')!!}
    {!! Html::style('/css/operations/mo.css') !!}
</div>
