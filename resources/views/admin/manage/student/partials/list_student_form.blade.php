<div ng-if="student.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_student_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="student.success">
			<p>{! student.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
				array(
					'id' => 'search_form'
					, 'class' => 'form-horizontal'
				)
			) !!}
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
				<div class="col-xs-2 admin-search-student">
					{!! Form::button(trans('messages.search'),
						array(
							'class' => 'btn btn-blue'
							, 'ng-click' => "student.searchFnc()"
						)
					) !!}
				</div>
				<div class="col-xs-2 admin-search-student">
					{!! Form::button(trans('messages.clear'),
						array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'student.clear()'
						)
					) !!}
				</div>
			</div>
            {!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container">
        <div class="dropdown">
            <button class="btn btn-blue btn-semi-medium dropdown-toggle" type="button" data-toggle="dropdown">
                {!! trans('messages.add_student') !!} <i class="fa fa-caret-square-o-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-medium">
                <li class="cursor-pointer" ng-click="student.setActive(futureed.ACTIVE_IMPORT)"><a><i class="fa fa-cloud-upload"></i> {!! trans('messages.import') !!}</a></li>
                <li class="cursor-pointer" ng-click="student.setActive(futureed.ACTIVE_ADD)"><a><i class="fa fa-plus-square"></i> {!! trans('messages.admin_manual') !!}</a></li>
            </ul>
        </div>


		<div class="list-container" ng-cloak ng-init="student.studentList()">
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_student_list') !!}
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
						<th>{!! trans('messages.points') !!}</th>
						<th ng-if="student.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>

				<tbody>
				<tr ng-repeat="record in student.records">
					<td>{! record.user.name !}</td>
					<td>{! record.user.email !}</td>
					<td>{! record.points !}</td>
					<td ng-if="student.records.length">
						<div class="row">

                            <div class="col-xs-3">
							<a ng-if="record.user.is_account_activated == 1
									&& record.user.is_account_locked == 0
									&& record.user.status == 'Enabled'
									&& record.user.session_token == NULL "
							   href="" ng-click="student.impersonate(record.user_id)"><span>
										<i ng-class="{ 'success-icon' : record.user.impersonate }" class="fa fa-user-secret"></i></span></a>
							<a ng-if="record.user.is_account_activated == 0
								|| record.user.is_account_locked == 1
								|| record.user.status == 'Disabled'
								|| record.user.session_token != NULL "
							   href="" ><span>
									<i ng-class="{ 'success-icon' : record.user.impersonate }" class="fa fa-user-secret text-danger"></i></span></a>
							</div>
							<div class="col-xs-3">
								<a href="" ng-click="student.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
							</div>
							<div class="col-xs-3">
								<a href="" ng-click="student.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
							</div>
							<div class="col-xs-3">
								<a href="" ng-click="student.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
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
	</div>
    {!! Form::open(
		array(
			'id' => 'login_form'
			, 'route' => 'student.login.process'
			, 'method' => 'POST'
		)
	) !!}
    {!! Form::hidden('user_data', '', array('id' => 'user_data')) !!}
    {!! Form::close() !!}
</div>