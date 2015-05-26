<div ng-if="!admin.add_admin && !admin.view_admin">
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
			<button class="btn btn-success btn-medium" ng-click="admin.addAdmin()"><span><i class="fa fa-plus-square"></i></span> Add </button>
		</div>
		<div class="table-container admin-table" ng-init="admin.getAdminList()">
					<div class="list-container" ng-cloak>
						<table id="client-list" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
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
				            <td width="250px">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-action" ng-hide="a.admin_role == 'Super Admin'">
					            			<a href="#" id="{! a.id !}">Disable</a>
					            		</div>
					            		<span class="separator" ng-hide="a.admin_role == 'Super Admin'">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="admin.viewAdmin(a.id)">View</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="admin.editAdmin(a.id)">Edit</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="sale.deletePrice(p.id)">Remove</a>
					            		</div>
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