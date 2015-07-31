<div class="container search-container" ng-if="question.active_list">
	<div class="title-mid">
		<span>Questions</span>
	</div>
	<div class="col-xs-12 question-container">
		<div class="row content-display">
			<div class="content-text">
				<p>{! question.details.questions_text !}</p>
				<div ng-if="question.details.questions_image != futureed.NONE">
					<img class="img-full" ng-src="{! question.details.questions_image !}">
				</div>
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