{{--TODO fill in the blanks for dynamic questions --}}
<div class="margin-top-30">

    <div ng-if="mod.current_question.question_type == futureed.FILLINBLANK" class="form-group">
        <div ng-class="{ 'fib-text-fields' : mod.current_question.answer_text_field_count.length > 1 }">
            <input ng-repeat="n in mod.current_question.answer_text_field_count track by $index"
                   ng-model="mod.current_question.answer_text[n]"
                   name="answer_text"
                   type="text" class="form-control question-text-answer form-control-lg"
                   placeholder="Answer {! (mod.current_question.answer_text_field_count.length > 1) ? $index + 1 : '' !}"
                    />
        </div>
    </div>
</div>