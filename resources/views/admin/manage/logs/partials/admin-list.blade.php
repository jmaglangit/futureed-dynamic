<div ng-if="logs.active_administrator_log">
	<div class="col-xs-12" ng-if="logs.errors || logs.success">
		<div class="alert alert-error" ng-if="logs.errors">
			<p ng-repeat="error in logs.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="logs.success">
            <p>{! logs.success !}</p>
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
					, 'ng-submit' => 'logs.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => trans('messages.username')
							, 'ng-model' => 'logs.search.username'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('email', ''
						,array(
							'placeholder' => trans('messages.email')
							, 'ng-model' => 'logs.search.email'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2 admin-search-admin-log">
					{!! Form::button(trans('messages.search')
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'logs.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('name', ''
						,array(
							'placeholder' => trans('messages.name')
							, 'ng-model' => 'logs.search.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-5">
					{!! Form::select('admin_type'
						, array(
							'' =>trans('messages.admin_select_admin_type')
							, 'Admin'=>'Admin'
							, 'Super Admin'=>'Super Admin'
						)
						, null
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.admin_type'
						)
					) !!}
				</div>
				
				<div class="col-xs-2 admin-search-admin-log">
					{!! Form::button(trans('messages.clear')
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'logs.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::select('result_response'
						, array(
							'' =>trans('messages.admin_response_code')
							, '200'=>'200'
							, '201'=>'201'
							, '404'=>'404'
							, '405'=>'405'
							, '500'=>'500'
							, '503'=>'503'
						)
						, null
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.result_response'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="table-container">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.logs') !!}
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
						'ng-model' => 'logs.table.size'
						, 'ng-change' => 'logs.paginateBySize()'
						, 'ng-if' => "logs.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>{!! trans('messages.username') !!}</th>
			            <th>{!! trans('messages.email') !!}</th>
			            <th>{!! trans('messages.name') !!}</th>
			            <th>{!! trans('messages.admin_type') !!}</th>
			            <th>{!! trans('messages.action') !!}</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="record in logs.records">
			            <td>{! record.username !}</td>
			            <td>{! record.email !}</td>
			            <td>{! record.name !}</td>
			            <td>{! record.admin_type !}</td>
			            <td>
							<div class="row">
								<div class="col-xs-12">
									<a href="" ng-click="logs.viewDetails(record)"><span><i class="fa fa-eye"></i></span></a>
								</div>
							</div>
						</td>
			        </tr>
			        <tr class="odd" ng-if="!logs.records.length && !logs.table.loading">
			        	<td valign="top" colspan="10">
			        		{!! trans('messages.no_records_found') !!}
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="logs.table.loading">
			        	<td valign="top" colspan="10">
			        		{!! trans('messages.loading') !!}
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="logs.records.length">
				<pagination 
					total-items="logs.table.total_items" 
					ng-model="logs.table.page"
					max-size="3"
					items-per-page="logs.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="logs.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="detail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_log_details') !!}
				</div>
				<div class="modal-body">
					<table class="col-xs-12 table table-striped table-bordered">
						<thead>
							<tr>
								<th>{!! trans('messages.admin_info') !!}</th>
								<th>{!! trans('messages.admin_value') !!}</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{!! trans('messages.username') !!}</td>
								<td>{! logs.record.username !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.name') !!}</td>
								<td>{! logs.record.name !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.email_address') !!}</td>
								<td>{! logs.record.email !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.admin_type') !!}</td>
								<td>{! logs.record.admin_type !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.admin_page_accessed') !!}</td>
								<td>{! logs.record.page_accessed !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.admin_api_accessed') !!}</td>
								<td>{! logs.record.api_accessed !}</td>
							</tr>

							<tr>
								<td>{!! trans('messages.admin_response_status') !!}</td>
								<td>{! logs.record.result_response !}</td>
							</tr>

							<tr class="odd" ng-if="!logs.record">
								<td valign="top" colspan="10">
									{!! trans('messages.no_records_found') !!}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button(trans('messages.close')
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