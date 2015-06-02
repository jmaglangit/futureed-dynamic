<div ng-if="teacher.active_list">
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
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
					)
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
					{!! Form::button('Search', 
						array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'teacher.list()'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear', 
						array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'teacher.clear()'
						)
					) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>

	<button class="btn btn-blue btn-small margin-0-30" ng-click="teacher.setActive('add')">
		<i class="fa fa-plus-square"></i> Add 
	</button>

	<div class="col-xs-12 mid-container">
		<div class="title-mid">
			Teacher List
		</div>
	</div>
	
	<div class="col-xs-12 table-container" ng-init="teacher.list()">
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

			<table id="teacher-list" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="t in teacher.records">
						<td>{! t.user.name !}</td>
						<td>{! t.user.email !}</td>
						<td>
							<div class="row">
			            		<div class="col-xs-3">
			            			{! t.user.status !}
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="teacher.view(t.id)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="teacher.edit(t.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-3">
			            			<a href="" ng-click="client.confirmDelete(t.id)"><span><i class="fa fa-trash	"></i></span></a>
			            		</div>
			            	</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!teacher.records.length && !teacher.table.loading">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="teacher.table.loading">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		Loading...
			        	</td>
			        </tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="teacher.records.length">
				<pagination 
					total-items="teacher.table.total_items" 
					ng-model="teacher.table.page"
					max-size="3"
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