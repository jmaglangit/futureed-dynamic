<div ng-if="age.active_list" id="age-group">
	<div class="col-xs-12 search-container" ng-if="age.errors || age.success">
		<div class="alert alert-error" ng-if="age.errors">
			<p ng-repeat="error in age.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="age.success">
			<p>{! age.success !}</p>
		</div>
	</div>

	<div class="table-container" ng-init="age.ageModuleList()">
		<button class="btn btn-blue btn-semi-medium" ng-click="age.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_age_group') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_age_group_list') !!}
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
						'ng-model' => 'age.table.size'
						, 'ng-change' => 'age.paginateBySize()'
						, 'ng-if' => "age.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table id="tip-list" class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.age') !!}</th>
						<th>{!! trans('messages.admin_total_points_earned') !!}</th>
						<th ng-if="age.records.length">{!! trans_choice('messages.action', 1) !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in age.records">
						<td>{! record.age_group.age !}</td>
						<td>{! record.points_earned !}</td>
						<td>
							<div class="row">
								<div class="col-xs-6">
									<a href="" ng-click="age.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-6">
									<a href="" ng-click="age.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!age.records.length && !age.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="age.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="age.records.length">
				<pagination 
					total-items="age.table.total_items" 
					ng-model="age.table.page"
					max-size="3"
					items-per-page="age.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="age.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="delete_age_group_modal" ng-show="age.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_delete_age_group') !!}
				</div>
				<div class="modal-body">
					{!! trans('messages.admin_delete_age_group_msg') !!}
				</div>
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button(trans('messages.yes')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'age.deleteAgeGroup()'
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