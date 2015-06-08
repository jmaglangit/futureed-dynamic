<div ng-if="student.list">
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
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'payment.search_order', 'placeholder' => 'Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Email</label>
				<div class="col-xs-5">
					{!! Form::text('search_order', '',['class' => 'form-control', 'ng-model' => 'payment.search_order', 'placeholder' => 'Email']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-blue btn-small margin-0-30" ng-click="payment.setActive('add')">
		<i class="fa fa-plus-square"></i> Add 
	</button>
	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Student List
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
						'ng-model' => 'admin.table.size'
						, 'ng-change' => 'admin.paginateBySize()'
						, 'ng-if' => "admin.data.length"
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
		        <tr>
		            <td>Bart Simpson</td>
		            <td>bart.simpson@simpson.com</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
	    						<a href="" ng-click="admin.viewAdmin(a.id)"><span><i class="fa fa-play"></i></span></a>
	    					</div>
		            		<div class="col-xs-4">
	    						<a href="" ng-click="admin.viewAdmin(a.id)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="admin.viewAdmin(a.id)"><span><i class="fa fa-pencil"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!admin.data.length && !admin.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="admin.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		Loading...
		        	</td>
		        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="admin.data.length">
				<pagination 
					total-items="admin.table.total_items" 
					ng-model="admin.table.page"
					max-size="admin.table.paging_size"
					items-per-page="admin.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="admin.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>