<div class="col-xs-12 margin-top-15 list-container" ng-if="help.active_view">
	<div class="content-box row margin-top-bot-5">
		<div class="help-container">
			<h3>{! help.details.title !}</h3>
			<div class="row">
				<p>{! help.details.created_at !}</p>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<p>{! help.details.subject_area_name !} > {! help.details.subject_name !}</p>
				</div>
				<div class="col-xs-6">
					<span><i class="fa fa-user"></i> By : {! help.details.name !}</span>
				</div>
			</div>
			<div class="row">
				<hr/>
				<p>{! help.details.content !}</p>
			</div>
		</div>
		<div class="help-container" ng-if="help.ans_record.length == 0">
			<div class="row">
				<h4>No Answers Yet</h4>	
			</div>
		</div>
		<div class="help-container" ng-repeat="rec in help.ans_record">
			<div class="row">
				<h4>{! rec.content !}</h4>
			</div>
			<div class="row">
				<div class="col-xs-6 pull-right">
					<span><i class="fa fa-user"></i> {! rec.student.first_name !} {! rec.student.last_name !}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 pull-right">
					<span ng-repeat="i in help.details.stars track by $index">
						<!-- <img ng-if="!answer.rating" ng-mouseover="help.changeColor($index, answer.id)" ng-src="{! (help.hovered[answer.id][$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
						<!-- <img ng-if="answer.rating" ng-src="{! $index + 1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
						<img ng-src="{! $index+1 <= rec.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
					</span>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-xs-12">
			{!! Form::open(['class' => 'form-horizontal']) !!}
			{!! Form::textarea('content', ''
                , array(
                    'class' => 'form-control toggle-input'
                    , 'placeholder' => 'Help Answer' 
                    , 'ng-model' => 'help.answer.content'
                    , 'autocomplete' => 'off'
                    , 'rows' => 6)
            ) !!}
		</div>
		<div class="row">
			<div class="col-xs-8 pull-right">
				<div class="btn-container">
					{!! Form::button('Submit Answer'
						, array(
						  'id' => 'validate_code_btn'
						  , 'class' => 'btn btn-maroon btn-medium'
						  , 'ng-click' => 'help.submitAnswer()'
						)
					) !!}
					{!! Form::button('Back'
						, array(
						  'id' => 'validate_code_btn'
						  , 'class' => 'btn btn-gold btn-medium'
						  , 'ng-click' => 'help.setCurrentActive()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>