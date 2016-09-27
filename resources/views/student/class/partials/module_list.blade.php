<div class="row">
	<div class="col-xs-12">
		<div class="class-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'class.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-2">
					{!! Form::text('search_name', ''
						,array(
							'placeholder' => trans_choice('messages.module', 1)
							, 'ng-model' => 'class.search.module_name'
							, 'class' => 'form-control btn-fit'
							, 'data-clear-btn' => 'true'
						)
					)!!}
				</div>
				<div class="col-xs-3">
					{!! Form::select('search_module_status'
						, array(
							'' => trans('messages.all')
							, 'On Going' => trans('messages.ongoing')
							, 'Completed' => trans('messages.completed')
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'class.search.module_status'
						)
					) !!}
				</div>
				<div class="col-xs-3" ng-init="getGradeLevel(user.country_id)">
					<select class="form-control" ng-model="class.search.grade_id">
						<option value="">{!! trans('messages.select_grade') !!}</option>
						<option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
					</select>
				</div>
				<div class="col-xs-2">
					{!! Form::button(trans('messages.search')
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'class.searchFnc($event)'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button(trans('messages.clear')
						, array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'class.clearFnc()'
						)
					) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 class-container">
		<ul class="nav nav-pills module-pills" role="tablist">
			<li role="presentation" class="module-tabs" ng-repeat="aClass in class.classes track by $index" ng-class="{ 'active' : aClass.class_id == class.current_class }"
				ng-click="class.redirectClass('{!! route('student.class.index') !!}', aClass.class_id)">
				<a href="#home" aria-controls="home" role="tab" data-toggle="tab" >{! aClass.classroom.subject.name !}</a>
			</li>
			<li role="presentation" class="module-tabs" ng-class="{ 'active' : aClass.class_id == class.current_class }">
				<a href="{!! route('student.reports.index') !!}">{!! trans('messages.reports') !!}</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active">
				<div class="list-container" ng-cloak>
					<div class="clearfix"></div>

					<div class="module-list" ng-if="!class.records.length && !class.table.loading">
						<div class="no-module-label">
							<p>{!! trans('messages.no_modules_found') !!}</p>
						</div>
					</div>

					<div class="module-list" ng-if="class.table.loading">
						<div class="no-module-label">
							<p>{!! trans('messages.loading') !!}</p>
						</div>
					</div>

					<div class="module-list" ng-if="class.records.length">
						<div class="module-item" ng-repeat="record in class.records">
							<div class="module-image-holder">
								<img ng-if="record.module_status != 'Completed' && user.points >= record.points_to_unlock" class="module-icon"
									 ng-src="{! record.icon_image == futureed.NONE && '/images/icons/default-module-icon.png' || record.icon_image !}"
									 ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name +' '+ record.grade.name !}">

								<img ng-if="record.module_status !== 'Completed' && user.points < record.points_to_unlock" class="locked-module-icon"
									 ng-src="/images/icons/icon-lock.png" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">

								<img ng-if="record.module_status == 'Completed'" class="locked-module-icon"
									 ng-src="{! record.icon_image == futureed.NONE && '/images/icons/default-module-icon.png' || record.icon_image !}" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">
							</div>

							<p class="module-name">{! record.name !}</p>

							<button ng-if="record.module_status == 'On Going' && user.points >= record.points_to_unlock"
									ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
									type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> {!! trans('messages.resume') !!} </button>

							<button ng-if="!record.module_status && user.points >= record.points_to_unlock" ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
									type="button" class="btn btn-blue module-btn"><i class="fa fa-pencil"></i> {!! trans('messages.begin') !!} </button>

							<button ng-if="user.points < record.points_to_unlock"
									type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> {!! trans('messages.locked') !!}</button>

							<button ng-if="record.module_status == 'Completed'"
									type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> {!! trans('messages.completed') !!}</button>

							<div class="progress">
								<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
									 ng-class="{
										'progress-bar-success' : record.progress > 75,
										'progress-bar-info' : record.progress > 50 && record.progress <= 75 ,
										'progress-bar-warning' : record.progress > 25 && record.progress <= 50 ,
										'progress-bar-danger' : record.progress <= 25,

									}"
									 ng-style="{ 'width' : record.progress+'%' }">
								</div>
							</div>
							<span class="module-progress">{! record.progress !}%</span>
						</div>
					</div>

					<div ng-if="class.records.length">
						<div class="previous-btn-position"
							 ng-if="class.table.page > 1">
							<span  ng-click="class.previousPage()"
								   ng-model="class.table.page">&lt;</span>
						</div>
						<div class="next-btn-position"
							 ng-if="class.total_module_items_loaded < class.table.total_items">
							<span  ng-click="class.nextPage()"
								   ng-model="class.table.page">&gt;</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>