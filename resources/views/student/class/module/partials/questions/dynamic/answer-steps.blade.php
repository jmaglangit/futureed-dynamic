{{--TODO answer steps and itirate here--}}
<div ng-if="mod.record.is_dynamic">
    {{--{! mod.current_question.question_values. !}--}}
    <div ng-if="mod.current_question.question_template.question_type == futureed.FILLINBLANK"
         ng-init="mod.parseQuestionValues(mod.current_question.question_values);mod.stepsRepeat(mod.question_values);">
        {{--itirate steps here--}}

            <div ng-if="mod.question_values.steps > futureed.TRUE" ng-repeat="n in mod.question_values_answer[0] track by $index" class="form-group">
                <label class="col-xs-2">Step {! $index+1 !}:</label>
                <input ng-model="mod.current_question.answer_text['steps_answer'][$index]"
                       name="steps_answer"
                       type="text" class="form-control question-text-answer"
                       placeholder="answer"
                        />
            </div>

        <div class="form-group">
            <label class="col-xs-2"> Total :</label>
            <input ng-model="mod.current_question.answer_text['total']"
                   name="total"
                   type="text" class="form-control question-text-answer form-control-lg"
                   placeholder="answer"
                    />
        </div>
    </div>

</div>