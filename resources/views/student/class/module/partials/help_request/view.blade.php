<div class="col-xs-12 margin-top-15" ng-if="help.active_view">
	<div class="view-help-btn">
		<div ng-if="help.record.student_id == user.id && help.record.question_status == futureed.OPEN">
			<button type="button" class="btn btn-maroon btn-small col-xs-6" ng-if="help.answers.length"
				ng-click="help.closeRequest(futureed.TRUE)"> {!! trans('messages.close_req') !!} </button>
			<button type="button" class="btn btn-maroon btn-small col-xs-6" ng-if="!help.answers.length"
				ng-click="help.deleteRequest(futureed.TRUE)"> {!! trans('messages.del_req') !!} </button>
		</div>

		<button type="button" class="btn btn-gold btn-small"
			ng-click="help.setModuleActive()"> {!! trans('messages.back') !!} </button>
	</div>

    <div class="alert alert-error" ng-if="help.errors">
	        <p ng-repeat="error in help.errors track by $index" > 
	            {! error !}
	        </p>
	    </div>
	    <div class="alert alert-success" ng-if="help.success">
	    	<p>{!! trans('messages.successful_submit_answer') !!}</p>
	    </div>

	<div id="help_request_details">
		<div class="view-help-container">
			<div class="content-box row margin-top-bot-5">
				<div>
					<div class="row">
						<div class="col-xs-6">
							<p class="tip-title">{! help.record.title !}</p class="title-mid">
						</div>
					</div>

					<div class="row">
						<div class="col-xs-6">
							<p><i class="fa fa-calendar-o"></i> {! help.record.created_moment !}</p>
						</div>
						<div class="col-xs-6">
							<span>{! help.record.question_status !}</span>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-6" ng-if="help.record.subject_area_name && help.record.subject_name">
							<span>{! help.record.subject_area_name !} > {! help.record.subject_name !}</span>
						</div>
						<div class="col-xs-6">
							<span><i class="fa fa-user"></i> {!! trans('messages.by') !!} : {! help.record.name !}</span>
						</div>
					</div>

					<div class="row">
						<hr/>
						<p>{! help.record.content !}</p>
					</div>
				</div>
			</div>
		</div>
		<fieldset>
			<legend class="tip-title">{!! trans('messages.answer') !!}</legend>
		</fieldset>
		<div class="help-answers-container" ng-repeat="answer in help.answers">
			<div class="content-box row margin-top-bot-5">
				<div class="content">
						<p>{! answer.content !}</p>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<p><i class="fa fa-calendar-o"></i> {! answer.created_moment !}</p>
					</div>
					<div class="col-xs-6">
						<span ng-repeat="star in answer.stars track by $index">
						<img class="unrated-star" ng-src="{! $index+1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
				</span>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6" ng-if="answer.subject_area_name && help.record.subject_name">
						<p>{! help.record.subject_area_name !} > {! help.record.subject_name !}</p>
					</div>
					<div class="col-xs-6">
						<span><i class="fa fa-user"></i> {!! trans('messages.by') !!} : {! answer.student.first_name !} {! answer.student.last_name !}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="help-answers-container" ng-if="help.record.question_status == futureed.OPEN">
			{!! Form::textarea('answer', ''
				, array(
					'class' => 'form-control disabled-textarea'
					, 'placeholder' => trans('messages.answer')
					, 'ng-model' => 'help.record.answer'
					, 'rows' => '5'
				)
			) !!}
		</div>

		<div class="btn-container" ng-if="help.record.question_status == futureed.OPEN">
			{!! Form::button(trans('messages.clear')
				, array(
					'class' => 'btn btn-gold btn-small pull-right'
					, 'ng-click' => "help.clearAnswer()"
				)
			) !!}

			{!! Form::button(trans('messages.submit')
				, array(
					'class' => 'btn btn-maroon btn-small pull-right'
					, 'ng-click' => "help.answerRequest()"
				)
			) !!}
		</div>
	</div>
</div>