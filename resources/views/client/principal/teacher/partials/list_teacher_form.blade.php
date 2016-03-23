<div ng-if="teacher.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.teacher_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="teacher.errors || teacher.success">
		<div class="alert alert-error" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="teacher.success">
			<p>{! teacher.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'teacher.searchFnc($event)'
					)
			) !!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('name', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'teacher.search.name'
							, 'placeholder' => 'trans('messages.name')'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					{!! Form::text('email', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'teacher.search.email'
							, 'placeholder' => 'trans('messages.email')'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.search')', 
						array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'teacher.searchFnc($event)'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.clear')', 
						array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'teacher.clearFnc()'
						)
					) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	
	<div class="col-xs-12 table-container" ng-init="teacher.listRecords()">
		<button class="btn btn-blue btn-semi-medium" ng-click="teacher.setActive('add')">
			<i class="fa fa-plus-square"></i> {!! trans('messages.teacher_invitation') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.teacher_list') !!}
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
						'ng-model' => 'teacher.table.size'
						, 'ng-change' => 'teacher.paginateBySize()'
						, 'ng-if' => "teacher.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.name') !!}</th>
						<th>{!! trans('messages.email') !!}</th>
						<th ng-if="teacher.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in teacher.records">
						<td>{! record.user.name !}</td>
						<td>{! record.user.email !}</td>
						<td>
							<div class="row">
								<div class="col-xs-3">
									<i class="fa" 
										ng-class="{ 'fa-ban error-icon' : record.user.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : record.user.status == futureed.ENABLED }"
										tooltip="{! record.user.status !}"
										tooltip-placement="top"
										tooltip-trigger="mouseenter"></i>
								</div>
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="teacher.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="teacher.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="teacher.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!teacher.records.length && !teacher.table.loading">
						<td valign="top" colspan="4">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="teacher.table.loading">
						<td valign="top" colspan="4">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="teacher.records.length">
				<pagination 
					total-items="teacher.table.total_items" 
					ng-model="teacher.table.page"
					max-size="3"
					items-per-page="teacher.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="teacher.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>