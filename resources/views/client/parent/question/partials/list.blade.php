<div class="container search-container" ng-if="question.active_list">
	<div class="title-mid">
		<span>Questions</span>
	</div>
	<div class="col-xs-12 question-container">
		<div class="row content-display">
			<div class="content-text">
				<p>{! question.details.questions_text !}</p>
				<div>
					<img ng-src="{! question.details.questions_image !}">
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-xs-offset-3 margin-30-top">
			<div class="row">
				<b>Answer/s:</b>
			</div>
			<div class="col-xs-6" ng-if="question.details.question_type == futureed.M_CHOICE" ng-repeat="answer in question.details.question_answers">
				<p ng-if="answer.answer_text">
					<span ng-if="answer.correct_answer == futureed.YES" class="success-icon"><i class="fa fa-check-circle-o"></i></span> {! answer.answer_text !}
				</p>
			</div>
			<div class="col-xs-6" ng-if="question.details.question_type != futureed.M_CHOICE">
				<p><span class="success-icon" ng-if="question.details.answer != futureed.NULL"><i class="fa fa-check-circle-o"></i></span> {! question.details.answer !}</p>
			</div>
		</div>
	</div>
	<div class="col-xs-12 btn-content">
		<div class="col-xs-4">
			<button class="btn btn-gold btn-medium" ng-click="question.viewQuestion(question.details.seq_no, futureed.BACK)" ng-if="question.details.seq_no != futureed.TRUE">Back</button>
		</div>
		<div class="col-xs-4">
			<center><h2 class="title-content">{! question.details.teaching_module !}</h2></center>
		</div>
		<div class="col-xs-4">
			<button class="btn btn-maroon btn-medium pull-right" ng-click="question.viewQuestion(question.details.seq_no, futureed.NEXT)" ng-if="question.details.seq_no != question.question_total">Next</button>
		</div>
	</div>
</div>