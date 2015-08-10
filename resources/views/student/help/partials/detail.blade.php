<div ng-if="help.active_view || help.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>Help Request Details</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
        </div>
    </div>
	
	<div class="form-content">
		<div id="detail_form" class="row"> 
			<div class="col-xs-12">
				<div class="col-xs-3 margin-top-8">
					<div class="col-xs-12 avatar-container-small">
						<img class="avatar-help" ng-src="{! help.record.avatar_url !}" />
					</div>
					<div class="avatar-name-container col-xs-12"> Posted by: {! help.record.name !}</div>
					<div class="help-status col-xs-12">
						Post Status: 
						<label ng-if="help.record.question_status == futureed.ANSWERED">
	        			<b class="success-icon">
	        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! help.record.question_status !}
	        			</b>
		        		</label>

		        		<label ng-if="help.record.question_status == futureed.OPEN">
		        			<b class="warning-icon">
		        				<i class="margin-top-8 fa fa-exclamation-circle"></i> {! help.record.question_status !}
		        			</b>
		        		</label>

		        		<label ng-if="help.record.question_status == futureed.CANCELLED">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! help.record.question_status !}
		        			</b>
		        		</label>
					</div>
					<div class="btn-help col-xs-12">
						{!! Form::button('View List'
							, array(
								'class' => 'btn btn-gold'
								, 'ng-click' => "help.setActive()"
							)
						) !!}

						<div ng-if="help.record.question_status == futureed.OPEN && help.record.own"> 
							{!! Form::button('Delete This Request'
								, array(
									'class' => 'btn btn-maroon margin-top-10'
									, 'ng-click' => "help.deleteRequest()"
									, 'ng-if' => '!help.answers.length'
								)
							) !!}

							{!! Form::button('Close This Request'
								, array(
									'class' => 'btn btn-maroon margin-top-10'
									, 'ng-click' => "help.closeRequest()"
									, 'ng-if' => 'help.answers.length'
								)
							) !!}
						</div>
					</div>
				</div>
				<div class="col-xs-9">
					<div class="panel panel-student">
						<div class="panel-heading row help-title">
							<h3 class="col-xs-9">{! help.record.title !}</h3>
							<p class="col-xs-2 pull-right time-right">{! help.record.created_moment !}</p>
						</div>
						<div class="clearfix"></div>
						<div class="panel-body">
							<div class="col-xs-12">
								<p>{! help.record.content !}</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12">
				<hr />
			</div>
			<fieldset class="col-xs-12">
				<legend>Answers</legend>
			</fieldset>
		</div>

		<div id="answers_form" class="answers-container row">
			<div class="col-xs-12 search-container" ng-if="!help.answers.length">
				<div class="form-search">
					<div class="form-group">
						No answers for now . . .
					</div>
				</div>
			</div>

			<div ng-repeat="answer in help.answers" ng-init="answer_index = $index" class="col-xs-12 answer-container">
				<div class="col-xs-3">
					<div class="col-xs-12 avatar-container-small">
						<img class="avatar-help" ng-src="{! answer.answer_av !}" />
					</div>
					<div class="avatar-name-container col-xs-12"> Answered by: {! answer.student.user.name !}</div>
					<div class="col-xs-12">
						<div class="rating-container">
							<span ng-repeat="i in help.record.stars track by $index">
								<!-- <img ng-if="!answer.rating" ng-mouseover="help.changeColor($index, answer.id)" ng-src="{! (help.hovered[answer.id][$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
								<!-- <img ng-if="answer.rating" ng-src="{! $index + 1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
								<img ng-src="{! $index+1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
							</span>
						</div>
					</div>
				</div>
				<div class="col-xs-9">
					<div class="bubble">
						<i>{! answer.content !}</i>
					</div>
					<div class="col-xs-2 pull-right margin-top-5">
						{! answer.created_moment !}
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 search-container" ng-if="help.record.question_status == futureed.OPEN">
			{!! Form::textarea('answer', ''
				, array(
					'class' => 'form-control'
					, 'placeholder' => 'Answer'
					, 'ng-model' => 'help.record.answer'
					, 'rows' => '5'
				)
			) !!}
		</div>

		<div class="btn-container search-container col-xs-12" ng-if="help.record.question_status == futureed.OPEN">
			{!! Form::button('Clear'
				, array(
					'class' => 'btn btn-gold btn-small pull-right'
					, 'ng-click' => "help.clearAnswer()"
				)
			) !!}

			{!! Form::button('Submit'
				, array(
					'class' => 'btn btn-maroon btn-small pull-right'
					, 'ng-click' => "help.answerRequest()"
				)
			) !!}
		</div>
	</div>
</div>