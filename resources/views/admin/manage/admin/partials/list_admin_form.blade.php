<div ng-if="admin.active_list_admin">
	<div class="content-title">
		<div class="title-main-content">
			<span>Admin Management</span>
		</div>
	</div>

	<div class="col-xs-12">
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
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Username <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'search_user', 'placeholder' => 'Username']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_email', '',['class' => 'form-control', 'ng-model' => 'search_email', 'placeholder' => 'Email']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Role <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::select('role', 
						array('' => '-- Select Role --' ,
							'Admin' => 'Admin', 
							'Super Admin' => 'Super Admin'), 
							null, 
							['ng-model' => 'search_role' , 'class' => 'form-control']
					) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium">Search</button>
					<button class="btn btn-gold btn-medium">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-4 add-admin">
			<button class="btn btn-success btn-medium" ng-click="admin.setManageAdminActive('add')"><span><i class="fa fa-plus-square"></i></span> Add </button>
		</div>
		<div class="table-container admin-table" ng-init="admin.getAdminList()">
					<div class="list-container" ng-cloak>
						<table id="" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
							<thead>
				        <tr>
				            <th>Username</th>
				            <th>Email</th>
				            <th>Role</th>
				            <th width="200px;">Actions</th>
				        </tr>
				        </thead>
				        <tbody>
				        <tr ng-repeat="a in admin.data">
				            <td>{! a.user.username !}</td>
				            <td>{! a.user.email !}</td>
				            <td>{! a.admin_role !}</td>
				            <td>
				            	<div class="row">
				            		<div class="col-xs-6">
	            						<a href="" ng-click="admin.viewAdmin(a.id)"><span><i class="fa fa-eye"></i></span></a>
	            					</div>
		            				<div class="col-xs-6">
		            					<a href="" ng-click="admin.editModeAdmin(a.id)"><span><i class="fa fa-pencil"></i></span></a>
		            				</div>
				            	</div>
				            </td>
				        </tr>
				        </tbody>

						</table>
					</div>
				</div>
	</div>
</div>