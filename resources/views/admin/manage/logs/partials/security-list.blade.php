<div ng-if="logs.active_security_log">
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
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Username'
							, 'ng-model' => 'logs.search.username'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('client_user_agent', ''
						,array(
							'placeholder' => 'Agent Used'
							, 'ng-model' => 'logs.search.client_user_agent'
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
					{!! Form::select('log_type'
						, array(
							'' =>' -- Select Log Type --'
							, 'Admin'=>'Admin'
							, 'User'=>'User'
						)
						, null
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.log_type'
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
						<th>IP Address</th>
						<th>Agent Used</th>
						<th>HTTP Response</th>
						<th>Log Type</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in logs.records">
						<td>{! record.username !}</td>
						<td>{! record.client_ip !}:{! record.client_port !}</td>
						<td>{! record.client_user_agent !}</td>
						<td>{! record.result_response !}</td>
						<td>{! record.log_type !}</td>
					</tr>
					<tr class="odd" ng-if="!logs.records.length && !logs.table.loading">
						<td valign="top" colspan="10">
							No records found
						</td>
					</tr>
					<tr class="odd" ng-if="logs.table.loading">
						<td valign="top" colspan="10">
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
</div>