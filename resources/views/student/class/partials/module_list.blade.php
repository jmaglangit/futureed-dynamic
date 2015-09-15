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
							'placeholder' => 'Module'
							, 'ng-model' => 'class.search.module_name'
							, 'class' => 'form-control btn-fit'
							, 'data-clear-btn' => 'true'
						)
					)!!}
				</div>
				<div class="col-xs-3">
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
				<div class="col-xs-3" ng-init="getGradeLevel(user.country_id)">
					<select class="form-control" ng-model="class.search.grade_id">
						<option value="">-- Select Grade --</option>
						<option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
					</select>
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'class.searchFnc($event)'
						)
					) !!}
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

	<div class="col-xs-12 class-container">
		<ul class="nav nav-pills module-pills" role="tablist" ng-init="class.listClass()">
			<li role="presentation" class="module-tabs" ng-repeat="aClass in class.classes track by $index" ng-class="{ 'active' : aClass.class_id == class.current_class }"
				ng-click="class.redirectClass('{!! route('student.class.index') !!}', aClass.class_id)">
				<div ng-if="$index == 0"><span ng-init="class.selectClass(aClass.class_id)"></span></div>
				<a href="#home" aria-controls="home" role="tab" data-toggle="tab" >{! aClass.classroom.subject.name !}</a>
			</li>
		</ul>

		<div class="tab-content">
		    <div class="tab-pane active">
				<div class="list-container" ng-cloak>
					<div class="clearfix"></div>

					<div class="module-list" ng-if="!class.records.length && !class.table.loading">
						<div class="no-module-label">
							<p>No modules found.</p>
						</div>
					</div>

					<div class="module-list" ng-if="class.table.loading">
						<div class="no-module-label">
							<p>Loading...</p>
						</div>
					</div>

					<div class="module-list" ng-if="class.records.length">
						<div class="module-item" ng-repeat="record in class.records">
							<div class="module-image-holder">
								<img ng-if="record.module_status != 'Completed' && user.points >= record.points_to_unlock" class="module-icon"
									ng-src="{! record.icon_image == futureed.NONE && '/images/icons/default-module-icon.png' || record.icon_image !}"
									ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">

								<img ng-if="record.module_status !== 'Completed' && user.points < record.points_to_unlock" class="locked-module-icon"
									ng-src="/images/icons/icon-lock.png" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">

								<img ng-if="record.module_status == 'Completed'" class="locked-module-icon"
									ng-src="/images/icons/default-module-icon.png" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">
							</div>

							<p class="module-name">{! record.name !}</p>

							<button ng-if="record.module_status == 'On Going' && user.points >= record.points_to_unlock"
								ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)" 
								type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> Resume lesson</button>

							<button ng-if="!record.module_status && user.points >= record.points_to_unlock" ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
								type="button" class="btn btn-blue module-btn"><i class="fa fa-pencil"></i> Begin lesson</button>

							<button ng-if="user.points < record.points_to_unlock"
								type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> Module Locked</button>

							<button ng-if="record.module_status == 'Completed'"
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
	</div>
</div>