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
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_MULTIPLICATION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
    </div>
    <div ng-if="template.record.operation == futureed.FRACTION_DIVISION">
        <p class="col-xs-12 h3" ng-bind-html="template.question_text | trustAsHtml"></p>
    </div>



    {!! Html::script('/js/common/operations/math_algo.js')!!}
    {!! Html::script('/js/common/operations/module_mapper.js')!!}
</div>