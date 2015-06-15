<div ng-if="class.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Class Management</span>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			<form ng-submit="class.searchFnc($event)" class="form-horizontal">
				<div class="form-group">
					<div class="col-xs-4">
						{!! Form::text('name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'class.search.name'
								, 'placeholder' => 'Class Name'
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>
					<div class="col-md-4" ng-init="class.getGradeLevel()">
	                    <select name="grade_id" class="form-control" ng-disabled="class.grades.length <= 0" ng-model="class.search.grade_id">
	                        <option value="">-- Select Level --</option>
	                        <option ng-repeat="grade in class.grades" value="{! grade.id !}">{! grade.name !}</option>
	                    </select>
	                </div>
					<div class="col-xs-2">
						{!! Form::button('Search', 
							array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'class.searchFnc()'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('Clear', 
							array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'class.clear()'
							)
						) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="class.list()">
		<div class="list-container" ng-cloak>
			<div class="title-mid">
				Class List
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
						'ng-model' => 'class.table.size'
						, 'ng-change' => 'class.paginateBySize()'
						, 'ng-if' => "class.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table id="class-list" class="table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>Grade</th>
		            <th>Class Name</th>
		            <th>No. of Seats Taken</th>
		            <th>No. of seats Enrolled</th>
		            <th ng-if="class.records.length">Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="classInfo in class.records">
		            <td>{! classInfo.grade.name !}</td>
		            <td>{! classInfo.name !}</td>
		            <td>{! classInfo.seats_taken !}</td>
		            <td>{! classInfo.seats_total !}</td>
		            <td ng-if="class.records.length">
		            	<div class="row">
		            		<div class="col-xs-4">
		            			{! classInfo.status !}
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="class.setActive('view',classInfo.id)"><span><i class="fa fa-eye"></i></span></a>
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="class.setActive('edit', classInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            	</div>
		            </td>
        		</tr>
        		<tr class="odd" ng-if="!class.records.length && !class.table.loading">
		        	<td valign="top" colspan="4">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="class.table.loading">
		        	<td valign="top" colspan="4">
		        		Loading...
		        	</td>
		        </tr>
	        	</tbody>
			</table>

			<div class="pull-right" ng-if="class.records.length">
				<pagination 
					total-items="class.table.total_items" 
					ng-model="class.table.page"
					max-size="3"
					items-per-page="class.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="class.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>