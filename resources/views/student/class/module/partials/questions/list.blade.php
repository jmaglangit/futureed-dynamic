<div class="col-xs-12">
	<div ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> Question #{! mod.question_counter !} </h3>
				<button ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed" type="button" class="btn btn-maroon next-btn" ng-click="mod.checkAnswer()"> Submit </button>
			</div>

			<div class="questions-image">
				<div class="col-xs-12" ng-if="mod.errors || mod.success">
					<div class="alert alert-error" ng-if="mod.errors">
						<p ng-repeat="error in mod.errors track by $index">
							{! error !}
						</p>
					</div>

					<div class="alert alert-success" ng-if="mod.success">
						<p>{! mod.success !}</p>
					</div>
				</div>
				
				<img ng-if="mod.current_question.original_image_name" ng-src="{! mod.current_question.questions_image !}" />
			</div>

			<div class="questions-message">
				<p ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
			</div>

			<div class="questions-answers">
				<a ng-if="mod.current_question.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in mod.current_question.question_answers"
					ng-click="mod.selectAnswer(choices)" ng-class="{ 'selected-choice' : mod.current_question.answer_id == choices.id }">
					<div ng-if="choices.answer_text != '' ">{! choices.answer_text !}</div>
					<img ng-if="choices.answer_image != 'None' " ng-src="{! choices.answer_image !}" />
				</a>

				<div ng-if="mod.current_question.question_type == futureed.FILLINBLANK" class="form-group">
					<div ng-class="{ 'fib-text-fields' : mod.current_question.answer_text_field_count.length > 1 }">
						<input ng-repeat="n in mod.current_question.answer_text_field_count track by $index" 
							ng-model="mod.current_question.answer_text[n]"
							name="answer_text" 
							type="text" class="form-control question-text-answer" placeholder="Answer {! $index + 1 !}" />
					</div>
				</div>

				<div ng-if="mod.current_question.question_type == futureed.PROVIDE" class="form-group">
					<input ng-model="mod.current_question.answer_text" name="answer_text" type="text" class="form-control question-text-answer" placeholder="Answer" />
				</div>

				<div ng-if="mod.current_question.question_type == futureed.ORDERING">
					<ul as-sortable="mod.dragControlListeners" ng-model="mod.current_question.answer_text">
						<li ng-repeat="item in mod.current_question.answer_text" as-sortable-item class="as-sortable-item">
							<div as-sortable-item-handle class="as-sortable-item-handle">
								<span data-ng-bind="item"></span>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<div class="questions-tips" ng-if="mod.current_question.question_type == futureed.ORDERING">
				<p> <img ng-src="{! user.avatar !}" /> <span>Drag the items to reorder. </span></p>
			</div>
		</div>
	</div>

	<div ng-if="mod.result.answered">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> Question #{! mod.question_counter !} </h3>
			</div>

			<div class="result-image">
				<i class="fa fa-5x img-rounded text-center"
					ng-class="{ 'fa-times' : !mod.result.points_earned, 'fa-check' : mod.result.points_earned }"></i>
			</div>

			<div class="result-message"
				ng-class="{ 'result-correct' : mod.result.points_earned, 'result-incorrect' : !mod.result.points_earned }">	
				<p ng-if="mod.result.points_earned > 0">
					Correct!
				</p>

				<p ng-if="mod.result.points_earned <= 0">
					Wrong.
				</p>
			</div>

			<div class="proceed-btn-container btn-container">
				<button type="button" class="btn btn-maroon btn-medium" ng-click="mod.nextQuestion()">
					Proceed to next Question
				</button>
			</div>
		</div>
	</div>

	<div ng-if="mod.result.quoted">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> Question #{! mod.question_counter !} </h3>
			</div>
			<div class="quote-message"
				ng-class="{ 'result-correct' : mod.result.points_earned, 'result-incorrect' : !mod.result.points_earned }">	
					<p ng-if="mod.result.points_earned > 0">
						Correct!
					</p>

					<p ng-if="mod.result.points_earned <= 0">
						Wrong.
					</p>
			</div>

			<div class="message-container">
				<div class="col-xs-12">
					<div class="col-xs-2"></div>
					<div class="module-icon-holder col-xs-3">
						<img ng-src="{! mod.avatar_quote_info.avatar_pose && '/images/avatar/' + mod.avatar_quote_info.avatar_pose.pose_image || user.avatar !}" />
					</div>

					<div class="col-xs-6">
						<p class="module-message">
							{! mod.avatar_quote_info.quote !} 
						</p>

						<div class="proceed-btn-container btn-container">
							<button type="button" class="btn btn-maroon btn-large" ng-click="mod.nextQuestion()">
								Proceed to next Question
							</button>
						</div>
					</div>
				</div>
			</div>


			
		</div>
	</div>

	<div ng-if="mod.result.failed">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> Question #{! mod.question_counter !} </h3>
			</div>

			<div class="result-failed message-container">
				<div class="col-xs-12">
					<div class="col-xs-2"></div>
					<div class="module-icon-holder col-xs-3">
						<img ng-src="{! user.avatar !}" />
					</div>

					<div class="col-xs-6">
						<p class="module-message">
							You need to review the teaching content.
						</p>

						<div class="proceed-btn-container btn-container">
							<button type="button" class="btn btn-maroon btn-large" ng-click="mod.reviewContent()">
								Review Contents
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>