<div ng-if="help.active_list">
	<div class="col-xs-12 success-container" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="help.success">
			<p>{! help.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'help.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_title', ''
						,array(
							'placeholder' => 'trans('messages.title')'
							, 'ng-model' => 'help.search.title'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => 'trans('messages.select_help_request_status')'
							, 'Pending' => 'trans('messages.pending')'
							, 'Accepted' => 'trans('messages.accepted')'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'help.search.request_status'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.search')'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'help.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_created', ''
						,array(
							'placeholder' => 'trans('messages.created_by')'
							, 'ng-model' => 'help.search.created'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-5"></div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.clear')'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'help.clearFnc()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_help_request_list') !!}
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
						'ng-model' => 'help.table.size'
						, 'ng-change' => 'help.paginateBySize()'
						, 'ng-if' => "help.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.title') !!}</th>
						<th>{!! trans('messages.created_by') !!}</th>
						<th>{!! trans('messages.date_created') !!}</th>
						<th>{!! trans('messages.date_last_answer') !!}</th>
						<th>{!! trans('messages.status') !!}</th>
						<th ng-if="help.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in help.records">
						<td>{! record.title !}</td>
						<td>{! record.student.first_name !} {! record.student.last_name !}</td>
						<td>{! record.created_at | ddMMyy : '-' !}</td>
						<td>{! record.last_answered_at | ddMMyy : '-' !}</td>
						<td>{! record.request_status !}</td>
						<td ng-if="help.records.length">
							<div class="row">
								<div class="col-xs-6">
									<a href="" ng-click="help.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-6">
									<a href="" ng-click="help.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!help.records.length && !help.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="help.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="help.records.length">
				<pagination 
					total-items="help.table.total_items" 
					ng-model="help.table.page"
					max-size="3"
					items-per-page="help.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="help.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>