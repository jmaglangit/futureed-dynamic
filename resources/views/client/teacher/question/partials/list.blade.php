<div class="container search-container" ng-if="question.active_list">
	<div class="title-mid">
		<span>Questions</span>
	</div>
	<div class="col-xs-12 question-container" ng-if="question.hide_difficulty">
		<div class="row content-display">
			<div class="content-text">
				<p>{! question.details.questions_text !}</p>
				<div ng-if="question.details.questions_image != futureed.NONE">
					<img class="img-full" ng-src="{! question.details.questions_image !}">
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 btn-content" ng-if="question.hide_difficulty">
		<div class="col-xs-4">
			<button class="btn btn-gold btn-medium" ng-click="question.viewQuestion(question.details.seq_no, futureed.BACK)" ng-if="question.details.seq_no != futureed.TRUE">Previous</button>
		</div>
		<div class="col-xs-4">
			<center><h2 class="title-content">{! question.details.teaching_module !}</h2></center>
		</div>
		<div class="col-xs-4">
			<button class="btn btn-maroon btn-medium pull-right" ng-click="question.viewQuestion(question.details.seq_no, futureed.NEXT)" ng-if="question.details.seq_no != question.question_total">Next</button>
		</div>
	</div>
	<div class="col-xs-12">
		{!! Form::open(['id' => 'difficulty', 'class' => 'form-horizontal']) !!}
		<div class="col-xs-6 col-xs-offset-3">
			<label class="control-label col-xs-4">Difficulty</label>
			<div class="col-xs-8">
				{!! Form::select('difficulty'
	                , array(
	                    '' => '-- Select Difficulty --'
	                    , '1' => '1'
	                    , '2' => '2'
	                    , '3' => '3')
	                , ''
	                , array(
	                    'class' => 'form-control'
	                    , 'ng-model' => 'question.details.difficulty_filter'
	                    , 'ng-change' => 'question.setDifficulty()'
	                )
	            ); !!}
			</div>
		</div>
	</div>
</div>