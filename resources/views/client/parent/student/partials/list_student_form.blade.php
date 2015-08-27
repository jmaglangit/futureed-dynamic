<div ng-if="student.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Student Management</span>
		</div>
	</div>
	<div class="alert-container col-xs-12" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
        <div class="alert alert-success" ng-if="student.success">
            <p> 
                {! student.success !}
            </p>
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
				<label class="col-xs-2 control-label">Name</label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'student.search.name', 'placeholder' => 'Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Email</label>
				<div class="col-xs-5">
					{!! Form::text('search_email', '',['class' => 'form-control', 'ng-model' => 'student.search.email', 'placeholder' => 'Email']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="student.getStudentlist()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="student.clear()">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<button class="btn btn-blue btn-small margin-0-30" ng-click="student.setActive('add')">
		<i class="fa fa-plus-square"></i> Add Student
	</button>
	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Student List
		</div>
	</div>
	<div class="col-xs-12 table-container" ng-init="student.list()">
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
						'ng-model' => 'student.table.size'
						, 'ng-change' => 'student.paginateBySize()'
						, 'ng-if' => "student.students.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Name</th>
			            <th>Email</th>
			            <th>Actions</th>
			        </tr>
			    </thead>

		        <tbody>
		        {{-- added sample data --}}
		        <tr ng-repeat="key in student.students">
		            <td>{! key.first_name !} {! key.last_name !}</td>
		            <td>{! key.user.email !}</td>
		            <td>
					<div class="row">
						<div class="col-xs-4">
							<a href="" ng-click="student.playStudent(key.id)"><span><i class="fa fa-play"></i></span></a>
						</div>
						<div class="col-xs-4">
							<a href="" ng-click="student.setActive('view', key.id)"><span><i class="fa fa-eye"></i></span></a>
						</div>
						<div class="col-xs-4">
							<a href="" ng-click="student.setActive('edit', key.id)"><span><i class="fa fa-pencil"></i></span></a>
						</div>
					</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!student.students.length && !student.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="student.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		Loading...
		        	</td>
		        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="student.students.length">
				<pagination 
					total-items="student.table.total_items" 
					ng-model="student.table.page"
					max-size="student.table.paging_size"
					items-per-page="student.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="student.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>