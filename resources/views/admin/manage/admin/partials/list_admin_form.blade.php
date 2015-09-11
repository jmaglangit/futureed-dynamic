<div ng-if="admin.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Admin Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="admin.errors || admin.success">
		<div class="alert alert-error" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="admin.success">
			<p ng-repeat="success in admin.success track by $index" > 
				{! success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'admin_search',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'admin.getAdminList()'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, [
							'class' => 'form-control'
							, 'ng-model' => 'admin.search.user'
							, 'placeholder' => 'Username'
						]
					) !!}
				</div>
				<div class="col-xs-5">
					{!! Form::text('search_email', ''
						, [
							'class' => 'form-control'
							, 'ng-model' => 'admin.search.email'
							, 'placeholder' => 'Email'
						]
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'admin.getAdminList()'
							)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::select('role', 
						array('' => '-- Select Role --' ,
							'Admin' => 'Admin', 
							'Super Admin' => 'Super Admin'), 
							null, 
							['ng-model' => 'admin.search.role' , 'class' => 'form-control']
					) !!}
				</div>
				<div class="col-xs-5"></div>
				<div class="col-xs-2">
					{!! Form::button('clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'admin.clearSearch()'
							)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-small" ng-click="admin.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Admin
		</button>

		<div class="list-container" ng-cloak>
			<div class="title-mid">
				Admin List
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
						'ng-model' => 'admin.table.size'
						, 'ng-change' => 'admin.paginateBySize()'
						, 'ng-if' => "admin.data.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Username</th>
			            <th>Email</th>
			            <th>Role</th>
			            <th>Actions</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="a in admin.data">
		            <td>{! a.user.username !}</td>
		            <td>{! a.user.email !}</td>
		            <td>{! a.admin_role !}</td>
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
	    						<a href="" ng-click="admin.setActive(futureed.ACTIVE_VIEW, a.id)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	        				<div class="col-xs-3">
	        					<a href="" ng-click="admin.setActive(futureed.ACTIVE_EDIT, a.id)"><span><i class="fa fa-pencil"></i></span></a>
	        				</div>
	        				<div class="col-xs-3">
	        					<a href="" ng-click="admin.confirmDelete(a.id)"><span><i class="fa fa-trash"></i></span></a>
	        				</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!admin.data.length && !admin.table.loading">
		        	<td valign="top" colspan="4">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="admin.table.loading">
		        	<td valign="top" colspan="4">
		        		Loading...
		        	</td>
		        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="admin.data.length">
				<pagination 
					total-items="admin.table.total_items" 
					ng-model="admin.table.page"
					max-size="admin.table.paging_size"
					items-per-page="admin.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="admin.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>