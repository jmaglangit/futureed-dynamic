<div ng-if="student.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Student Management</span>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="title-mid mid-container">
			Search
		</div>
	</div>
	<div class="col-xs-12 search-container">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
        <div class="alert alert-success" ng-if="student.validation.success">
            <p> 
                {! student.validation.success !}
            </p>
        </div>
		<div class="form-search">
			{!! Form::open(
				array(
					'id' => 'search_form'
					, 'class' => 'form-horizontal'
				)
			) !!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('search_name', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'student.search.name'
							, 'placeholder' => 'Name'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					{!! Form::text('search_email', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'student.search.email'
							, 'placeholder' => 'Email'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search', 
						array(
							'class' => 'btn btn-blue'
							, 'ng-click' => "student.getStudentlist('search')"
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear', 
						array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'student.clear()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="student.list()">
		<div class="list-container" ng-cloak>
			<button class="btn btn-blue btn-small" ng-click="student.setActive('add')">
				<i class="fa fa-plus-square"></i> Add Student
			</button>

			<div class="title-mid">
				Student List
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
			            <th>Points</th>
			            <th>Actions</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="key in student.students">
		            <td>{! key.first_name !} {! student.last_name !}</td>
		            <td>{! key.user.email !}</td>
		            <td>{! key.points !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
	    						<a href="" ng-click="student.setActive('view', key.id)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="student.setActive('edit', key.id)"><span><i class="fa fa-pencil"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="student.confirmDelete(key.id)"><span><i class="fa fa-trash"></i></span></a>
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