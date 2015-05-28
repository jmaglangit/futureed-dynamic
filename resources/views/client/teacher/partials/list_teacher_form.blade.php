<div ng-if="teacher.client_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Teacher Management</span>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="title-mid mid-container">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Name <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_email', '',['class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 mid-container">
		<div class="title-mid">
			Teacher List
		</div>
	</div>
	<div class="col-xs-4 add-admin mid-container">
			<button class="btn btn-blue btn-medium" ng-click="teacher.setActive('add')"><span><i class="fa fa-plus-square"></i></span> Add </button>
		</div> 
	<div class="col-xs-12 table-container" ng-init="teacher.getTeacherList()">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Name</th>
		            <th>Email</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="t in teacher.teacherinfo">
		            <td>{! t.first_name !} {! t.last_name !}</td>
		            <td>{! t.user.email !}</td>
		            <td width="250px">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-action">
					            			<a href="" ng-click="teacher.viewTeacher(t.id)">View</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="" ng-click="admin.editAdmin(a.id)">Edit</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="" ng-click="sale.deletePrice(p.id)">Remove</a>
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