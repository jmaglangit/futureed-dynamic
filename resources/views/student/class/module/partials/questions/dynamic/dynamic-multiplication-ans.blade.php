<div ng-show="mod.record.is_dynamic == futureed.TRUE && mod.current_question.question_template.operation == futureed.MULTIPLICATION">
    <div id="examPane" style="display: none;">
        <!-- answer area -->
        <div
                style="float: left; width: 20%;"
                id="answerPane">
            <div id="lastDiv"></div>
        </div>
        <div style="float: left; width: 20%;">
            <b style="color: #005588;   ">Answered Flow</b>
            <div id="lastDiv2"></div><br>
        </div>
        <div style="float: left; width: 20%;">
            <b style="color: #005588;">Correct Answer Flow</b>
            <div id="lastDiv3"></div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>