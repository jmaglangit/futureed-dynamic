<div class="col-xs-12 teacher-module-container" ng-if="question.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span><i class="fa fa-lightbulb-o"></i> {!! trans('messages.question') !!} </span>

			<div class="col-xs-2 pull-right">
				<span>
					<a href="{!! route('client.teacher.module.index') !!}" class="btn btn-gold teacher-module-back">{!! trans('messages.back') !!}</a>
				</span>
			</div>
		</div>
	</div>

	<div class="view-contents-btn">
		<button class="btn btn-green" ng-click="question.viewContents('{!! route('client.teacher.teaching_content.index') !!}')">{!! trans('messages.view_contents') !!}</button> 
	</div>

	<div class="col-xs-12 question-search-container">
		<div class="form-search">
			{!! Form::open(array('class' => 'form-horizontal', 'ng-submit' => 'question.searchFnc($event)'))!!}
			<div class="form-group">
				<div class="col-xs-3"></div>
				<div class="col-xs-4">
					{!! Form::select('search_status'
						, array(
							'' => trans('messages.select_difficulty')
							, '1' => '1'
							, '2' => '2'
							, '3' => '3'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'question.search.difficulty'
							, 'ng-change' => 'question.searchFnc($event)'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button(trans('messages.clear')
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'question.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="no-content-container col-xs-12" ng-if="!question.record">
		<div class="alert alert-info">
			<center><span><i class="fa fa-info-circle"></i> {!! trans('messages.no_questions_available') !!}</span></center>
		</div>
	</div>

	<div class="view-question-container col-xs-12" ng-if="question.record">
		<div class="content-body">
			<div class="question-image" ng-if="question.record.questions_image != 'None'">
				<img ng-src="{! question.record.questions_image !}" />
			</div>

			<div class="question-message">
				<p ng-bind-html="question.record.questions_text | trustAsHtml"></p>
			</div>
		</div>
	</div>

	
	<div class="content-pagination" ng-if="question.record">
		<pagination 
			total-items="question.table.total_items" 
			ng-model="question.table.page"
			max-size="3"
			items-per-page="question.table.size" 
			previous-text = "&lt;"
			next-text="&gt;"
			class="pagination" 
			boundary-links="true"
			ng-change="question.paginateByPage()">
		</pagination>
	</div>
</div>