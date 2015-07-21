<div ng-if="student.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Student Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="student.success">
            <p>{! student.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
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
							, 'ng-click' => "student.searchFnc()"
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

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-small" ng-click="student.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Student
		</button>

		<div class="list-container" ng-cloak ng-init="student.studentList()">
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
						, 'ng-if' => "student.records.length"
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
			            <th ng-if="student.records.length">Actions</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="record in student.records">
		            <td>{! record.user.name !}</td>
		            <td>{! record.user.email !}</td>
		            <td>{! record.points !}</td>
		            <td ng-if="student.records.length">
		            	<div class="row">
		            		<div class="col-xs-4">
	    						<a href="" ng-click="student.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="student.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="student.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!student.records.length && !student.table.loading">
		        	<td valign="top" colspan="7">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="student.table.loading">
		        	<td valign="top" colspan="7">
		        		Loading...
		        	</td>
		        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="student.records.length">
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