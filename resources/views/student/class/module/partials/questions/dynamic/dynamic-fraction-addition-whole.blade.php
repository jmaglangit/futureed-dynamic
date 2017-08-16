<div>
    <div style="visibility:hidden">
        <input type="text" style="width:50px" name="randomDigits" id="randomDigits" required autofocus value="4">
        <p ng-init="mod.dynamicQuestionSetup(mod.current_question)"></p>
        <table>
            <tr>
                <td rowspan="3" align="center" valign="middle"><input type="text" style="width:50px" name="w1" id="w1" value=""></td>
                <td align="center"><input type="text" style="width:50px" name="z1" id="z1" value=""></td>
                <td rowspan="3" align="center" valign="middle"><b> + </b></td>
                <td rowspan="3" align="center" valign="middle"><input type="text" style="width:50px" name="w2" id="w2" value=""></td>
                <td align="center"><input type="text" style="width:50px" name="z2" id="z2" value=""></td>
                <td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>
                <td align="center" class="verybigtext">?</td>
            </tr>
            <tr>
                <td bgcolor="#000000" height="2"></td>
                <td bgcolor="#000000" height="2"></td>
                <td bgcolor="#000000" height="2"></td>
            </tr>
            <tr>
                <td align="center"><input type="text" style="width:50px" name="m1" id="m1" value=""></td>
                <td align="center"><input type="text" style="width:50px" name="m2" id="m2" value=""></td>
                <td align="center" class="verybigtext">?</td>
            </tr>
        </table>
    </div>

    <div>
        <!-- questions area -->
        <div id="questionPane" class="col-xs-6 answer_area">
            <p class="m-top-20 h4" ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
            <div id="examPane" style="display: none;" class="h4">
                    <table>

                        <tr>
                            <td colspan="5"></td>
                        </tr>

                        <tr class="h4">
                            <td rowspan="3" align="center" valign="middle"><label id="subject_w1_b"></label></td>
                            <td align="center"><label id="subject_z1_b"></label></td>
                            <td rowspan="3" align="center" valign="middle"><b> + </b></td>
                            <td rowspan="3" align="center" valign="middle"><label id="subject_w2_b"></label></td>
                            <td align="center"><label id="subject_z2_b"></label></td>
                            <td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>
                            <td align="center" class="verybigtext">?</td>
                        </tr>
                        <tr>
                            <td bgcolor="#000000" height="2"></td>
                            <td bgcolor="#000000" height="2"></td>
                        </tr>
                        <tr class="h4">
                            <td align="center"><label id="subject_m1_b1"></label></td>
                            <td align="center"><label id="subject_m2_b1"></label></td>
                            <td align="center" class="verybigtext">?</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <!-- answer area -->
        <div id="step_div" class="answer_area col-xs-6 pull-right h4">
            <div id="whole" class="h4 m-top-20"></div>
            <div id="questionsz" class="m-top-20"></div>
            <div id="questionsm" class="m-top-20"></div>
            <div id="simplify" class="m-top-20"></div>
            <div id="combine" class="m-top-20"></div>
            <div id="answer" class="m-top-20"></div>
        </div>

        <div id="tipsFlow" class="answer_area" style="display: none;">
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
                    <div id="Answer_correct_flow"></div>
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
                <button id="close_modal" type="button" class="btn btn-gold btn-medium pull-right" data-dismiss="modal" onclick="closeModal()" style="display: none;">Close</button>
                <button id="yes_simplify_modal" type="button" class="btn btn-green btn-medium pull-left" onclick="btnYEsOnclick()">
                    {!! trans('messages.yes') !!}</button>
                <button id="no_simplify_modal" type="button" class="btn btn-gold btn-medium pull-right" onclick="btnNOOnclick()">
                    {!! trans('messages.no') !!}</button>
                <button id="yes_whole_modal" type="button" class="btn btn-green btn-medium pull-left" onclick="wholebtnYEsOnclick()">
                    {!! trans('messages.yes') !!}</button>
                <button id="no_whole_modal" type="button" class="btn btn-gold btn-medium pull-right" onclick="wholebtnNOOnclick()">
                    {!! trans('messages.no') !!}</button>
                <button id="yes_combine_modal" type="button" class="btn btn-green btn-medium pull-left" onclick="combinebtnYEsOnclick()">
                    {!! trans('messages.yes') !!}</button>
                <button id="no_combine_modal" type="button" class="btn btn-gold btn-medium pull-right" onclick="combinebtnNOOnclick()">
                    {!! trans('messages.no') !!}</button>
                <button id="yes_can_simplify_modal" type="button" class="btn btn-green btn-medium pull-left" onclick="combinebtnNOOnclick()">
                    {!! trans('messages.yes') !!}</button>
            </div>
        </div>
    </div>

    {!! Html::script('/js/common/operations/fraction_addition_whole.js')!!}
</div>
