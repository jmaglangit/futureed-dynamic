<div ng-if="logs.active_users_log">
	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
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
					{!! Form::text('page_accessed', ''
						,array(
							'placeholder' => 'Page Accessed'
							, 'ng-model' => 'logs.search.page_accessed'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('api_accessed', ''
						,array(
							'placeholder' => 'API Accessed'
							, 'ng-model' => 'logs.search.api_accessed'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'logs.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::select('result_response'
						, array(
							'' =>' -- Select Response Code --'
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
				
				<div class="col-xs-5">
					{!! Form::select('user_type'
						, array(
							'' =>' -- Select User Type --'
							, 'Client'=>'Client'
							, 'Student'=>'Student'
						)
						, null
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.user_type'
						)
					) !!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'logs.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Username'
							, 'ng-model' => 'logs.search.username'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="table-container">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				Logs
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
						<th>Username</th>
						<th>Email</th>
			            <th>Name</th>
						<th>User Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in logs.records">
						<td>{! record.username !}</td>
			            <td>{! record.email !}</td>
			            <td>{! record.name !}</td>
						<td>{! record.user_type !}</td>
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
							No records found
						</td>
					</tr>
					<tr class="odd" ng-if="logs.table.loading">
						<td valign="top" colspan="7">
							Loading...
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
					Log Details
				</div>
				<div class="modal-body">
					<table class="col-xs-12 table table-striped table-bordered">
						<thead>
							<tr>
								<th>Info</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Username</td>
								<td>{! logs.record.username !}</td>
							</tr>

							<tr>
								<td>Name</td>
								<td>{! logs.record.name !}</td>
							</tr>

							<tr>
								<td>Email Address</td>
								<td>{! logs.record.email !}</td>
							</tr>

							<tr>
								<td>User Type</td>
								<td>{! logs.record.user_type !}</td>
							</tr>

							<tr>
								<td>Page Accessed</td>
								<td>{! logs.record.page_accessed !}</td>
							</tr>

							<tr>
								<td>API Accessed</td>
								<td>{! logs.record.api_accessed !}</td>
							</tr>

							<tr>
								<td>Response Status</td>
								<td>{! logs.record.result_response !}</td>
							</tr>

							<tr class="odd" ng-if="!logs.record">
								<td valign="top" colspan="10">
									No records found
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button('Close'
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