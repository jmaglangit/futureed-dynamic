<div class="row">
	<div class="col-xs-12">
		<div class="module-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'class.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						,array(
							'placeholder' => 'Module'
							, 'ng-model' => 'class.search.name'
							, 'class' => 'form-control btn-fit'
							, 'data-clear-btn' => 'true'
						)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_module_status'
						, array(
							'' => 'All'
							, 'Available' => 'Available'
							, 'Ongoing' => 'Ongoing'
							, 'Completed' => 'Completed'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'class.search.module_status'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'class.searchFnc($event)'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5" ng-init="getGradeLevel(user.country_id)">
					<select class="form-control" ng-model="class.search.grade_id">
						<option value="">-- Select Grade --</option>
						<option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
					</select>
				</div>
				<div class="col-xs-5" ng-init="class.getSubjects()">
					<select class="form-control" ng-model="class.search.subject_id">
						<option value="">-- Select Subject --</option>
						<option ng-repeat="subject in class.subjects" ng-value="subject.id">{! subject.name !}</option>
					</select>
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
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

	<div class="col-xs-12 table-container">
		<div class="clearfix"></div>

		<div class="title-mid">
			Class Modules
		</div>

		<div class="list-container" ng-init="class.listModules()" ng-cloak>
			<div class="size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'class.table.size'
						, 'ng-change' => 'class.paginateBySize()'
						, 'ng-if' => "class.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>

			<div class="no-record-label" ng-if="!class.records.length && !class.table.loading">
				No modules found.
			</div>

			<div class="no-record-label" ng-if="class.table.loading">
				Loading...
			</div>

			<div class="module-list" ng-if="class.records.length">
				<div class="module-item" ng-repeat="record in class.records" tooltip-class="module-tooltip" tooltip-placement="top" tooltip="{! record.name !}">
					<div class="module-image-holder">
						<img ng-if="record.student_module[0].module_status != 'Completed'" ng-class="{ 'module-icon' : user.points >= record.points_to_unlock, 'locked-module-icon' : user.points < record.points_to_unlock}" 
							ng-src="{! user.points >= record.points_to_unlock && '/images/icons/default-module-icon.png' || '/images/icons/icon-lock.png' !}"
							ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)">

						<img ng-if="record.student_module[0].module_status == 'Completed'" class="locked-module-icon"
							ng-src="/images/icons/default-module-icon.png">
					</div>

					<p class="module-name">{! record.name !}</p>

					<button ng-if="record.student_module.length && record.student_module[0].module_status == 'On Going' && user.points >= record.points_to_unlock"
						ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)" 
						type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> Resume lesson</button>

					<button ng-if="!record.student_module.length && user.points >= record.points_to_unlock" ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
						type="button" class="btn btn-blue module-btn"><i class="fa fa-pencil"></i> Begin lesson</button>

					<button ng-if="user.points < record.points_to_unlock"
						type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> Module Locked</button>

					<button ng-if="record.student_module.length && record.student_module[0].module_status == 'Completed'"
						type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> Module Completed</button>

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
			
			<div class="pull-right" ng-if="class.records.length">
				<pagination 
					total-items="class.table.total_items" 
					ng-model="class.table.page"
					max-size="3"
					items-per-page="class.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="class.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>