<div>
    {{--operations--}}
    <div ng-if="template.record.operation == futureed.ADDITION">
        <div id="questionPane">
            {{--<p class="col-xs-6 h3">Find the sum of <label id="subject_number1_p"></label> + <label id="subject_number2_p"></label></p><br>--}}
            <p class="col-xs-12 h3" ng-bind-html="template.question_preview | trustAsHtml"></p>
            {{--<button onclick="startAnswer();">Start Answer</button>--}}
        </div>
    </div>


</div>