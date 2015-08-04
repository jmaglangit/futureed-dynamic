<div class="questions-container col-xs-8">
	<div class="questions-header">
		<h3> Question #{! mod.questions.seq_no !} </h3>
	</div>

	<div class="questions-image">
		<img src="/images/avatar/doctor-male/doctor_male-2_main.png" />
	</div>

	<div class="questions-message">
		<p ng-bind-html="mod.questions.questions_text | trustAsHtml"></p>
	</div>

	<div class="questions-answers" ng-class="{ 'col-xs-12' : mod.questions.question_type == futureed.FILLINBLANK }">
		<a ng-if="mod.questions.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in mod.questions.question_answers"
			ng-click="mod.selectAnswer(choices)" ng-class="{ 'selected-choice' : mod.questions.answer_id == choices.id }">{! choices.answer_text !}</a>
		
		<div ng-if="mod.questions.question_type == futureed.FILLINBLANK || mod.questions.question_type == futureed.PROVIDE" class="form-group">
			<input ng-model="mod.questions.answer_text" type="text" class="form-control question-text-answer" placeholder="Answer" />
		</div>
	</div>

	<div class="questions-tips">

	</div>

	<div class="questions-btn-container">
		<button type="button" class="btn btn-maroon exit-btn" ng-click="mod.exitModule()">Exit Module</button>
		<button type="button" class="btn btn-gold next-btn" ng-click="mod.checkAnswer()"> Next </button>
	</div>
</div>

<ul dnd-list="list">
    <!-- The dnd-draggable directive makes an element draggable and will
         transfer the object that was assigned to it. If an element was
         dragged away, you have to remove it from the original list
         yourself using the dnd-moved attribute -->
    <li ng-repeat="item in mod.list track by $index"
        dnd-draggable="item"
        dnd-moved="mod.list.splice($index, 1)"
        dnd-effect-allowed="move"
        dnd-selected="mod.models.selected = item"
        ng-class="{'selected': mod.models.selected === item}"
        >
        {! item.label !}
    </li>
</ul>