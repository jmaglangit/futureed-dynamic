<div ng-if="admin.active_list_admin">
	<div class="content-title">
		<div class="title-main-content">
			<span>Admin Management</span>
		</div>
	</div>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="alert alert-error" ng-if="admin.errors">
            <p ng-repeat="error in admin.errors track by $index" > 
                {! error !}
            </p>
        </div>
        <div class="alert alert-success" ng-if="admin.validation.c_success">
            <p> 
                {! admin.validation.c_success !}
            </p>
        </div>
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'admin_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, [
							'class' => 'form-control'
							, 'ng-model' => 'admin.search_user'
							, 'placeholder' => 'Username'
						]
					) !!}
				</div>
				<div class="col-xs-5">
					{!! Form::text('search_email', ''
						, [
							'class' => 'form-control'
							, 'ng-model' => 'admin.search_email'
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
							['ng-model' => 'admin.search_role' , 'class' => 'form-control']
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

	<button class="btn btn-blue btn-small margin-0-30" ng-click="admin.setManageAdminActive('add')">
		<i class="fa fa-plus-square"></i> Add 
	</button>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Admin List
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="" datatable="ng" class="table table-striped table-hover dt-responsive" style="width:100%">
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
	            		<div class="col-xs-4">
    						<a href="#" ng-click="admin.viewAdmin(a.id)"><span><i class="fa fa-eye"></i></span></a>
    					</div>
        				<div class="col-xs-4">
        					<a href="#" ng-click="admin.editModeAdmin(a.id)"><span><i class="fa fa-pencil"></i></span></a>
        				</div>
        				<div class="col-xs-4">
        					<a href="" ng-click="admin.confirmDelete(a.id)"><span><i class="fa fa-trash"></i></span></a>
        				</div>
	            	</div>
	            </td>
	        </tr>
	        </tbody>

			</table>
		</div>
	</div>
</div>