{{--TODO answer steps and itirate here--}}
<div ng-if="mod.record.is_dynamic">
    {{--{! mod.current_question.question_values. !}--}}
    <div ng-if="mod.current_question.question_template.question_type == futureed.FILLINBLANK"
         ng-init="mod.parseQuestionValues(mod.current_question.question_values);mod.stepsRepeat(mod.question_values.steps);">
        {{--itirate steps here--}}

        <div ng-if="mod.question_values.steps > futureed.TRUE" ng-repeat="n in mod.question_values_answer track by $index" class="form-group">
            <label class="col-xs-2">Step {! $index+1 !}:</label>
            <div ng-if = "mod.current_question.question_template.operation == futureed.ADDITION" class="form-group">
              <label class="steps_label col-xs-4">Add the {! n.step_index !}</label>
            </div>
            <div ng-if = "mod.current_question.question_template.operation == futureed.SUBTRACTION" class="form-group">
              <label class="steps_label col-xs-4">Subtract the {! n.step_index !}</label>
            </div>
            <input ng-model="mod.current_question.answer_text['steps_answer'] [$index]"
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
