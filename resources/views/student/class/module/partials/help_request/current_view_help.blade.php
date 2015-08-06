<div class="col-xs-12 margin-top-15 list-container" ng-if="mod.active_current_view">
	<div class="content-box row margin-top-bot-5">
		<div class="help-container">
			<h3>{! mod.details.title !}</h3>
			<div class="row">
				<p>{! mod.details.created_at !}</p>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<p>{! mod.details.subject_area_name !} > {! mod.details.subject_name !}</p>
				</div>
				<div class="col-xs-6">
					<span><i class="fa fa-user"></i> By : {! mod.details.name !}</span>
				</div>
			</div>
			<div class="row">
				<hr/>
				<p>{! mod.details.content !}</p>
			</div>
		</div>
		<div class="help-container" ng-if="mod.ans_record.length == 0">
			<div class="row">
				<h4>No Answers Yet</h4>	
			</div>
		</div>
		<div class="help-container" ng-repeat="rec in mod.ans_record">
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
					<span ng-repeat="i in mod.details.stars track by $index">
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
                    , 'ng-model' => 'mod.answer.content'
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
						  , 'ng-click' => 'mod.submitAnswer()'
						)
					) !!}
					{!! Form::button('Back'
						, array(
						  'id' => 'validate_code_btn'
						  , 'class' => 'btn btn-gold btn-medium'
						  , 'ng-click' => 'mod.setCurrentActive()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>