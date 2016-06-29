<div ng-if="student.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_student_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="student.success">
			<p> 
				{! student.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		{!! Form::open(
				[
					'id' => 'teacher_search',
					'class' => 'form-horizontal'
				]
		) !!}
			<div class="form-search">
				<div class="form-group">
					<div class="col-xs-4">
						{!! Form::text('search_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'student.search.name'
								, 'placeholder' => trans('messages.name')
							)
						) !!}
					</div>
					<div class="col-xs-4">
						{!! Form::text('search_email', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'student.search.email'
								, 'placeholder' => trans('messages.email')
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button(trans('messages.search')
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'student.searchFnc($event)'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button(trans('messages.clear')
							, array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'student.clear()'
							)
						) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	
	<div class="col-xs-12 table-container" ng-init="student.list()">
		<button class="btn btn-blue btn-semi-medium" ng-click="student.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.add_student') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.student_list') !!}
			</div>

			<div class="col-xs-6 size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'student.table.size'
						, 'ng-change' => 'student.paginateBySize()'
						, 'ng-if' => "student.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.name') !!}</th>
						<th>{!! trans('messages.email') !!}</th>
						<th ng-if="student.records.length">{!! trans_choice('messages.action', 2) !!}</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="record in student.records">
						<td>{! record.user.name !}</td>
						<td>{! record.user.email !}</td>
						<td>
							<div class="row" ng-if="record.parent.status != futureed.DISABLED">
								<div class="col-xs-4">
									<a href="javascript:void(0)" ng-click="student.playStudent(user.id,record.id)"><span><i class="fa fa-play"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="javascript:void(0)" ng-click="student.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="javascript:void(0)" ng-click="student.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
							</div>

							<div class="form-group" ng-if="record.parent.status == futureed.DISABLED" ng-cloak>
								<div class="col-xs-12 btn-container">
									<a href="javascript:void(0)" class="btn btn-blue"
									   ng-click="student.setActive(futureed.INVITE)">{!! trans('messages.confirm_invitation') !!}</a>
								</div>
							</div>

						</td>
					</tr>
					<tr class="odd" ng-if="!student.records.length && !student.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="student.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="student.records.length">
				<pagination 
					total-items="student.table.total_items" 
					ng-model="student.table.page"
					max-size="student.table.paging_size"
					items-per-page="student.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="student.paginateByPage()">
				</pagination>
			</div>
		</div>

		{!! Form::open(
				array(
					'id' => 'redirect_form'
					, 'route' => 'student.post.login'
					, 'method' => 'POST'
				)
			) !!}
				{!! Form::hidden('id', '') !!}
			{!!Form::close() !!}
	</div>
</div>