<div ng-if="teacher.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Student Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="teacher.errors || teacher.success">
		<div class="alert alert-error" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="teacher.success">
            <p>{! teacher.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('name', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'teacher.search.name'
							, 'placeholder' => 'Name'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					{!! Form::text('email', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'teacher.search.email'
							, 'placeholder' => 'Email'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'teacher.searchFnc()'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						, array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'teacher.clearSearch()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="teacher.listStudent()">
		<div class="title-mid">
			Student List
		</div>

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
						'ng-model' => 'teacher.table.size'
						, 'ng-change' => 'teacher.paginateBySize()'
						, 'ng-if' => "teacher.records.length"
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
			        <tr ng-repeat="student in teacher.records">
			        	<td>{! student.user.name!}</td>
			            <td>{! student.user.email !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-6">
		    						<a href="" ng-click="teacher.studentDetails(student.id, futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
		    					</div>
		    					<div class="col-xs-6">
		    						<a href="" ng-click="teacher.studentDetails(student.id, futureed.ACTIVE_EDIT)"><span><i class="fa fa-pencil"></i></span></a>
		    					</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!teacher.records.length && !teacher.table.loading">
			        	<td valign="top" colspan="7">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="teacher.table.loading">
			        	<td valign="top" colspan="7">
			        		Loading...
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="teacher.records.length">
				<pagination 
					total-items="teacher.table.total_items" 
					ng-model="teacher.table.page"
					max-size="teacher.table.paging_size"
					items-per-page="teacher.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="teacher.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>