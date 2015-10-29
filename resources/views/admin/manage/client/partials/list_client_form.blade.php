<div ng-if="client.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Client Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="client.errors || client.success">
		<div class="alert alert-error" ng-if="client.errors">
			<p ng-repeat="error in client.errors track by $index" > 
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="client.success">
			<p> 
				{! client.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>
		
		{!! Form::open(
			array('id' => 'search_form'
				, 'class' => 'form-horizontal'
				, 'ng-submit' => 'client.getClientList()'
			)
		)!!}
		<div class="form-search">
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						,array(
							'placeholder' => 'Name'
							, 'ng-model' => 'client.search.name'
							, 'class' => 'form-control'
							)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::text('search_email', ''
						,array(
							'placeholder' => 'Email Address'
							, 'ng-model' => 'client.search.email'
							, 'class' => 'form-control'
							)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'client.searchFnc()'
						)
					)!!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_school', ''
						,array(
							'placeholder' => 'School'
							, 'ng-model' => 'client.search.school'
							, 'class' => 'form-control'
							)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_role'
						, array(
							'' => '-- Select Role --'
							, 'Parent' => 'Parent'
							, 'Teacher' => 'Teacher'
							, 'Principal' => 'Principal'
						)
						, null
						, array(
							'placeholder' => 'Email Address'
							, 'ng-model' => 'client.search.client_role'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'client.clearFnc()'
							)
					)!!}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	 
	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="client.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Client
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				Client List
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
						'ng-model' => 'client.table.size'
						, 'ng-change' => 'client.paginateBySize()'
						, 'ng-if' => "client.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered" >
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Account Status</th>
						<th ng-if="client.records.length">Action</th>
					</tr>
				</thead>
				 <tbody>
					<tr ng-repeat="record in client.records">
						<td>{! record.first_name !} {! record.last_name !}</td>
						<td>{! record.user.email !}</td>
						<td>{! record.client_role !}</td>
						<td>{! record.account_status !}</td>
						<td>
							<div class="row">
								<div class="col-xs-3">
									<i class="fa" 
										ng-class="{ 'fa-ban error-icon' : record.user.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : record.user.status == futureed.ENABLED }"
										tooltip="{! record.user.status !}"
										tooltip-placement="top"
										tooltip-trigger="mouseenter"></i>
								</div>
								<div class="col-xs-2">
									<a ng-if="record.account_status == 'Accepted' && record.user.session_token == NULL "
									   href="" ng-click="client.impersonate(record.user_id)"><span>
									<i ng-class="{ 'success-icon' : record.user.impersonate }" class="fa fa-user-secret"></i></span></a>
									<a ng-if="record.account_status != 'Accepted' || record.user.session_token != NULL"
									   href="" ><span>
									<i ng-class="{ 'success-icon' : record.user.impersonate }" class="fa fa-user-secret text-danger"></i></span></a>
								</div>
								<div class="col-xs-2">
									<a href="" ng-click="client.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-2">
									<a href="" ng-click="client.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-2">
									<a href="" ng-click="client.confirmDelete(record.id)"><span><i class="fa fa-trash	"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!client.records.length && !client.table.loading">
						<td valign="top" colspan="5">
							No records found
						</td>
					</tr>
					<tr class="odd" ng-if="client.table.loading">
						<td valign="top" colspan="5">
							Loading...
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="client.records.length">
				<pagination 
					total-items="client.table.total_items" 
					ng-model="client.table.page"
					max-size="3"
					items-per-page="client.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="client.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	{!! Form::open(
		array(
			'id' => 'login_form'
			, 'route' => 'client.login.process'
			, 'method' => 'POST'
		)
	) !!}
		{!! Form::hidden('user_data', '', array('id' => 'user_data')) !!}
	{!! Form::close() !!}
</div>