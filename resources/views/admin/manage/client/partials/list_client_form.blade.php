<div ng-if="client.active_client_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Client Management</span>
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
				array('id' => 'search_form'
					, 'method' => 'POST'
					, 'class' => 'form-inline'
					)
				)!!}
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
			<div class="form-group" style="margin-top:20px;">
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
	</div>

	<button class="btn btn-blue btn-small margin-0-30" ng-click="client.setManageClientActive('add_client')">
		<i class="fa fa-plus-square"></i> Add 
	</button>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Client List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
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
						, 'ng-if' => "client.clients.length != '0'"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered" >
				<thead>
			        <tr>
			            <th>Name</th>
			            <th>Email</th>
			            <th>Role</th>
			            <th>Action</th>
			        </tr>
		        </thead>
		         <tbody>
			        <tr ng-repeat="a in client.clients">
			            <td>{! a.first_name !} {! a.last_name !}</td>
			            <td>{! a.user.email !}</td>
			            <td>{! a.client_role !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-6">
			            			<a href="" ng-click="client.setManageClientActive('view_client',a.id)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-6">
			            			<a href="" ng-click="client.setManageClientActive('edit_client', a.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<!-- <div class="col-xs-3">
			            			<span><i class="fa fa-ban"></i></span>
			            		</div>
			            		<div class="col-xs-3">
			            			<span><i class="fa fa-trash	"></i></span>
			            		</div>	 -->
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="client.clients.length == '0'">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		No data available in table
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="client.table.loading">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		Loading...
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="client.table.page_count > 1">
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