<div ng-if="module.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_module_mgmt') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="module.errors || module.success">
		<div class="alert alert-error" ng-if="module.errors">
			<p ng-repeat="error in module.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="module.success">
			<p>{! module.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'module.searchFnc($event)'
					]
			) !!}
				<div class="form-group">
					<div class="col-xs-5" ng-init="module.getSubject()">
						<select ng-model="module.search.subject" ng-disabled="!module.subjects.length" class="form-control">
							<option value="">{!! trans('messages.admin_select_subject') !!}</option>
							<option ng-repeat="subject in module.subjects" ng-value="subject.name"> {! subject.name !} </option>
						</select>
					</div>
					<div class="col-xs-5">
						{!! Form::text('area_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.area'
								, 'placeholder' => trans('messages.subject_area')
							)
						) !!}
					</div>
					<div class="col-xs-2 admin-search-module">
						{!! Form::button(trans('messages.search')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'module.searchFnc($event)'
							)
						)!!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::text('module_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.name'
								, 'placeholder' => trans('messages.admin_module_name')
							)
						) !!}
					</div>
					<div class="col-xs-5" ng-init="getGradeLevel()">
						<select class="form-control" ng-model="module.search.grade_id">
							<option value="">{!! trans('messages.select_grade') !!}</option>
							<option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
						</select>
					</div>
					<div class="col-xs-2 admin-search-module">
						{!! Form::button(trans('messages.clear')
							,array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'module.clearFnc($event)'
							)
						)!!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="module.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_module') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_module_list') !!}
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
						'ng-model' => 'module.table.size'
						, 'ng-change' => 'module.paginateBySize()'
						, 'ng-if' => "module.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans_choice('messages.module', 1) !!}</th>
						<th>{!! trans('messages.subject') !!}</th>
						<th>{!! trans('messages.area') !!}</th>
						<th>{!! trans_choice('messages.grade', 1) !!}</th>
						<th ng-if="module.records.length">{!! trans_choice('messages.action', 2) !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in module.records">
						<td>{! record.name !}</td>
						<td>{! record.subject.name !}</td>
						<td>{! record.subject_area.name !}</td>
						<td>{! record.grade.name !}</td>
						<td ng-if="module.records.length">
							<div class="row">
								<div class="col-xs-3">
									<a href="" ng-click="module.setActive(futureed.ACTIVE_VIEW, record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_view_module') !!}"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="" ng-click="module.setActive(futureed.ACTIVE_EDIT, record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_edit_module') !!}"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="{!! route('admin.manage.module.question') . "?module=" !!}{! record.id !}" target="_blank" ng-click="module.openQuestionPreview(record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_module_preview_questions') !!}"><span><i class="fa fa-search-plus"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="" ng-click="module.confirmDelete(record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_delete_module') !!}"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!module.records.length">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="module.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="module.records.length">
				<pagination 
					total-items="module.table.total_items" 
					ng-model="module.table.page"
					max-size="3"
					items-per-page="module.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="module.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="delete_module_modal" ng-show="module.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_delete_module') !!}
				</div>
				<div class="modal-body">
					{!! trans('messages.admin_delete_module_msg') !!}
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button(trans('messages.yes')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'module.deleteModule()'
								, 'data-dismiss' => 'modal'
							)
						) !!}

						{!! Form::button(trans('messages.no')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'data-dismiss' => 'modal'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>