<div ng-if="client.active_client_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Client Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="client.errors || client.validate.c_success">
		<div class="alert alert-error" ng-if="client.errors">
            <p ng-repeat="error in client.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="client.validate.c_success">
            <p> 
                {! client.validate.c_success !}
            </p>
        </div>
    </div>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
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
							, 'ng-click' => 'client.getClientList()'
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
							, 'ng-click' => 'client.clearSearchForm()'
							)
					)!!}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	 
	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-small" ng-click="client.setManageClientActive('add_client')">
			<i class="fa fa-plus-square"></i> Add Client
		</button>

		<div class="list-container" ng-cloak>
			<div class="title-mid">
				Client List
			</div>

			<div class="size-container">
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
						, 'ng-if' => "client.clients.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered" >
				<thead>
			        <tr>
			            <th class="width-200">Name</th>
			            <th class="width-200">Email</th>
			            <th>Role</th>
			            <th>Account Status</th>
			            <th>Action</th>
			        </tr>
		        </thead>
		         <tbody>
			        <tr ng-repeat="a in client.clients">
			            <td>{! a.first_name !} {! a.last_name !}</td>
			            <td>{! a.user.email !}</td>
			            <td>{! a.client_role !}</td>
			            <td>{! a.account_status !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-3">
			            			<i class="fa" 
			            				ng-class="{ 'fa-ban error-icon' : a.user.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : a.user.status == futureed.ENABLED }"
			            				tooltip="{! a.user.status !}"
			            				tooltip-placement="top"
			            				tooltip-trigger="mouseenter"></i>
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="client.setManageClientActive('view_client',a.id)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="client.setManageClientActive('edit_client', a.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="client.confirmDelete(a.id)"><span><i class="fa fa-trash	"></i></span></a>
			            		</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!client.clients.length && !client.table.loading">
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

			<div class="pull-right" ng-if="client.clients.length">
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
</div>