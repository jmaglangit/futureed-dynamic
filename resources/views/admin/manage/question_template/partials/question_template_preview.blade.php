<div>
    {{--operations--}}
    <div ng-if="template.record.operation == futureed.ADDITION">
        <div id="questionPane">
            <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        </div>
        {!! Html::script('/js/common/operations/addition.js')!!}
        {!! Html::script('/js/common/operations/global.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.SUBTRACTION">
        <div id="questionPane">
            <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        </div>
        {!! Html::script('/js/common/operations/subtraction.js')!!}
        {!! Html::script('/js/common/operations/global.js?20170713')!!}
    </div>
    <div ng-if="template.record.operation == futureed.MULTIPLICATION">
        <div id="questionPane">
            <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        </div>
        {!! Html::script('/js/common/operations/multiplication.js')!!}
        {!! Html::script('/js/common/operations/global.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.DIVISION">
        <div id="questionPane">
            <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        </div>
        {!! Html::script('/js/common/operations/division_main.js')!!}
        {!! Html::script('/js/common/operations/division2.js?20170715')!!}
        {!! Html::script('/js/common/operations/global.js?20170715')!!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_ADDITION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <div id="examPane" style="display: none;" class="h4">
            <table>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr class="h4">
                    <td align="center">
                        <label id="subject_z1_b"></label>
                    </td>
                    <td rowspan="3" align="center" valign="middle">
                        <b> + </b>
                    </td>
                    <td align="center"><label id="subject_z2_b"></label></td>
                    <td rowspan="3" align="center" valign="middle" class="verybigtext">
                        <b>=</b>
                    </td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
                <tr>
                    <td bgcolor="#000000" height="2"></td>
                    <td bgcolor="#000000" height="2"></td>
                </tr>
                <tr class="h4">
                    <td align="center"><label id="subject_m1_b"></label></td>
                    <td align="center"><label id="subject_m2_b"></label></td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
            </table>
        </div>
        {!! Html::script('/js/common/operations/fraction_addition.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822')!!}

    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_ADDITION_WHOLE">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
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
        {!! Html::script('/js/common/operations/fraction_addition_whole.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_ADDITION_BUTTERFLY">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <table>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr class="h4">
                <td align="center">
                    <label id="subject_z1_b"></label>
                </td>
                <td rowspan="3" align="center" valign="middle">
                    <b> + </b>
                </td>
                <td align="center"><label id="subject_z2_b"></label></td>
                <td rowspan="3" align="center" valign="middle" class="verybigtext">
                    <b>=</b>
                </td>
                <td align="center" class="verybigtext">?</td>
            </tr>
            <tr>
                <td bgcolor="#000000" height="2"></td>
                <td bgcolor="#000000" height="2"></td>
            </tr>
            <tr class="h4">
                <td align="center"><label id="subject_m1_b"></label></td>
                <td align="center"><label id="subject_m2_b"></td>
                <td align="center" class="verybigtext">?</td>
            </tr>
        </table>
        {!! Html::script('/js/common/operations/fraction_addition_butterfly.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <div id="examPane" style="display: none;" class="h3">
            <table>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr class="h4">
                    <td align="center">
                        <label id="subject_z1_b"></label>
                    </td>
                    <td rowspan="3" align="center" valign="middle">
                        <b> - </b>
                    </td>
                    <td align="center"><label id="subject_z2_b"></label></td>
                    <td rowspan="3" align="center" valign="middle" class="verybigtext">
                        <b>=</b>
                    </td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
                <tr>
                    <td bgcolor="#000000" height="2"></td>
                    <td bgcolor="#000000" height="2"></td>
                </tr>
                <tr class="h4">
                    <td align="center"><label id="subject_m1_b"></label></td>
                    <td align="center"><label id="subject_m2_b"></label></td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
            </table>
        </div>
        {!! Html::script('/js/common/operations/fraction_subtraction.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_BUTTERFLY">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <table>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr class="h4">
                <td align="center">
                    <label id="subject_z1_b"></label>
                </td>
                <td rowspan="3" align="center" valign="middle">
                    <b> - </b>
                </td>
                <td align="center"><label id="subject_z2_b"></label></td>
                <td rowspan="3" align="center" valign="middle" class="verybigtext">
                    <b>=</b>
                </td>
                <td align="center" class="verybigtext">?</td>
            </tr>
            <tr>
                <td bgcolor="#000000" height="2"></td>
                <td bgcolor="#000000" height="2"></td>
            </tr>
            <tr class="h4">
                <td align="center"><label id="subject_m1_b"></label></td>
                <td align="center"><label id="subject_m2_b"></td>
                <td align="center" class="verybigtext">?</td>
            </tr>
        </table>
        {!! Html::script('/js/common/operations/fraction_subtraction_butterfly.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_WHOLE">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <table>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr class="h4">
                <td rowspan="3" align="center" valign="middle"><label id="subject_w1_b"></label></td>
                <td align="center"><label id="subject_z1_b"></label></td>
                <td rowspan="3" align="center" valign="middle"><b> - </b></td>
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
                <td align="center"><label id="subject_m1_b"></label></td>
                <td align="center"><label id="subject_m2_b"></label></td>
                <td align="center" class="verybigtext">?</td>
            </tr>
        </table>
        {!! Html::script('/js/common/operations/fraction_subtraction_whole.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_MULTIPLICATION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <div id="examPane" style="display: none;" class="h3">
            <table>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr class="h4">
                    <td align="center">
                        <label id="subject_z1_b"></label>
                    </td>
                    <td rowspan="3" align="center" valign="middle">
                        <b> X </b>
                    </td>
                    <td align="center"><label id="subject_z2_b"></label></td>
                    <td rowspan="3" align="center" valign="middle" class="verybigtext">
                        <b>=</b>
                    </td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
                <tr>
                    <td bgcolor="#000000" height="2"></td>
                    <td bgcolor="#000000" height="2"></td>
                </tr>
                <tr class="h4">
                    <td align="center"><label id="subject_m1_b"></label></td>
                    <td align="center"><label id="subject_m2_b"></td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
            </table>
        </div>
        {!! Html::script('/js/common/operations/fraction_multiplication.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_DIVISION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <div id="examPane" style="display: none;" class="h4">
            <table>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr class="h4">
                    <td align="center">
                        <label id="subject_z1_b"></label>
                    </td>
                    <td rowspan="3" align="center" valign="middle">
                        <b> / </b>
                    </td>
                    <td align="center"><label id="subject_z2_b"></label></td>
                    <td rowspan="3" align="center" valign="middle" class="verybigtext">
                        <b>=</b>
                    </td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
                <tr>
                    <td bgcolor="#000000" height="2"></td>
                    <td bgcolor="#000000" height="2"></td>
                </tr>
                <tr class="h4">
                    <td align="center"><label id="subject_m1_b"></label></td>
                    <td align="center"><label id="subject_m2_b"></td>
                    <td align="center" class="verybigtext">?</td>
                </tr>
            </table>
        </div>
        {!! Html::script('/js/common/operations/fraction_division.js')!!}
        {!! Html::script('/js/common/operations/fraction_global.js?20170822') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_ADDITION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <p class="h3"><b id="firstNumber_b">200</b>
            <label id="firstDigits_label"></label> and <b id="secondNumber_b">2</b>
            <label id="secondDigits_label"></label>?</p>
        {!! Html::script('/js/common/operations/integer_addition.js')!!}
        {!! Html::script('/js/common/operations/global.js') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_CONVERT_NUMBER">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js?20170806')!!}
        {!! Html::script('/js/common/operations/integer_convert_number.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_COUNTING">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/integer_global.js')!!}
        {!! Html::script('/js/common/operations/integer_counting.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_DECIMAL">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        <p><label><b id="str_interger_b"></b>.<b id="str_decimal_b"></b></label></p>
        {!! Html::script('/js/common/operations/global.js?20170806')!!}
        {!! Html::script('/js/common/operations/integer_decimal.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_EXPANDED_DECIMAL">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/integer_expanded_decimal.js')!!}
        {!! Html::script('/js/common/operations/global.js') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_EXTENDED">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/integer_extended.js')!!}
        {!! Html::script('/js/common/operations/global.js') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_IDENTIFY">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js?20170806')!!}
        {!! Html::script('/js/common/operations/integer_identify.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_REGROUP">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/integer_regroup.js')!!}
        {!! Html::script('/js/common/operations/global.js') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_ROUNDING_NUMBER">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/integer_rounding_number.js')!!}
        {!! Html::script('/js/common/operations/global.js') !!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_SORT_LARGE">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js?20170806')!!}
        {!! Html::script('/js/common/operations/sort_max.js?20170806.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.INTEGER_SORT_SMALL">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js?20170806')!!}
        {!! Html::script('/js/common/operations/sort_min.js?20170806.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.DECIMAL_ADDITION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js')!!}
        {!! Html::script('/js/common/operations/decimal_addition.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.DECIMAL_COMPARE">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js')!!}
        {!! Html::script('/js/common/operations/decimal_compare.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.DECIMAL_NUMERIC">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js')!!}
        {!! Html::script('/js/common/operations/decimal_numeric.js')!!}
    </div>
    <div ng-if="template.record.operation == futureed.DECIMAL_UNDERSTAND">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
        {!! Html::script('/js/common/operations/global.js')!!}
        {!! Html::script('/js/common/operations/decimal_understand.js')!!}
    </div>



    {!! Html::script('/js/common/operations/math_algo.js')!!}
    {!! Html::script('/js/common/operations/module_mapper.js')!!}
</div>