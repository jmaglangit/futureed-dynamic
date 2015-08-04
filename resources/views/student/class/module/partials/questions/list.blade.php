<div class="questions-container col-xs-8">
	<div class="questions-header">
		<h3> Question #{! mod.questions.seq_no !} </h3>
	</div>

	<div ng-if="!mod.question.answered">
		<div class="questions-image">
			<img ng-if="mod.questions.original_image_name" src="/images/avatar/doctor-male/doctor_male-2_main.png" />
		</div>

		<div class="questions-message">
			<p ng-bind-html="mod.questions.questions_text | trustAsHtml"></p>
		</div>

		<div class="questions-answers">
			<a ng-if="mod.questions.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in mod.questions.question_answers"
				ng-click="mod.selectAnswer(choices)" ng-class="{ 'selected-choice' : mod.questions.answer_id == choices.id }">{! choices.answer_text !}</a>
			
			<div ng-if="mod.questions.question_type == futureed.FILLINBLANK || mod.questions.question_type == futureed.PROVIDE" class="form-group">
				<input ng-model="mod.questions.answer_text" type="text" class="form-control question-text-answer" placeholder="Answer" />
			</div>

			<div ng-if="mod.questions.question_type == futureed.ORDERING">
				<ul as-sortable="mod.dragControlListeners" ng-model="mod.questions.answer_text">
	                <li ng-repeat="item in mod.questions.answer_text" as-sortable-item class="as-sortable-item">
	                    <div as-sortable-item-handle class="as-sortable-item-handle">
	                        <span data-ng-bind="item"></span>
	                    </div>
	                </li>
	            </ul>
			</div>
		</div>

		<div class="questions-tips" ng-if="mod.questions.question_type == futureed.ORDERING">
			<p> <img src="/images/user_teacher.png" /> <span>Drag the items to reorder. </span></p>
		</div>
	</div>

	<div ng-if="mod.question.answered">
		<div class="questions-image roundcon">
			<i class="fa fa-times fa-5x img-rounded text-center"></i>
		</div>

		<div class="questions-tips">
			
		</div>
	</div>

	<div class="questions-btn-container">
		<button type="button" class="btn btn-maroon exit-btn" ng-click="mod.exitModule()">Exit Module</button>
		<button type="button" class="btn btn-gold next-btn" ng-click="mod.checkAnswer()"> Next </button>
	</div>
</div>