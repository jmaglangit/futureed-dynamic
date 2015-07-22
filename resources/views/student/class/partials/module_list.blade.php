<div class="row">
	<div class="col-xs-12">
		<div class="module-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'tips.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Module'
							, 'ng-model' => 'tips.search.module'
							, 'class' => 'form-control btn-fit'
							, 'data-clear-btn' => 'true'
						)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => 'All'
							, 'Available' => 'Available'
							, 'Ongoing' => 'Ongoing'
							, 'Completed' => 'Completed'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.search.status'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => '-- Grade --'
							, '1' => 'Grade 1'
							, '2' => 'Grade 2'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.search.grade_id'
						)
					) !!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => '-- Subject --'
							, 'English' => 'English'
							, 'Math' => 'Math'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.search.subject'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						, array(
							'class' => 'btn btn-gold'
						)
					) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-6 col-xs-offset-3">

		{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'tips.searchFnc($event)'
				)
			)!!}
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
						'ng-model' => 'tips.table.size'
						, 'ng-change' => 'tips.paginateBySize()'
						, 'ng-if' => "tips.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>

			<div class="no-record-label">
				You do not have a module yet...
			</div>

			<div class="module-list">
				<div class="module-item">
					<a href="{!! route('student.class.modulename',['name' => 'sample-page']) !!}">
						<img class="module-icon" src="/images/cake.png">
					</a>

					<p class="module-name">Ball</p>
					<button type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> Resume lesson</button>
				</div>
				<div class="module-item">
					<a href="{!! route('student.class.modulename',['name' => 'sample-page']) !!}">
						<img class="module-icon" src="/images/class-student/icon-addition.png">
					</a>

					<p class="module-name">Ball Ball Ball Ball Ball Ball</p>
					<button type="button" class="btn btn-blue module-btn"><i class="fa fa-pencil"></i> Begin Lesson</button>
				</div>
				<div class="module-item">
					<a href="{!! route('student.class.modulename',['name' => 'sample-page']) !!}">
						<img class="module-icon" src="/images/cake.png">
					</a>

					<p class="module-name">BallBallBallBallBallBallBallBallBallBallBallBallBallBall</p>
					<button type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> Resume Lesson</button>
				</div>
			</div>
			
			<div class="pull-right" ng-if="tips.records.length">
				<pagination 
					total-items="tips.table.total_items" 
					ng-model="tips.table.page"
					max-size="3"
					items-per-page="tips.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="tips.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>