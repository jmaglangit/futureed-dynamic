<div ng-if="module.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Module Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="module.errors || module.success">
		<div class="alert alert-error" ng-if="module.errors">
			<p ng-repeat="error in module.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="module.success">
            <p>{! module.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'module.searchFnc($event)'
					]
			) !!}
				<div class="form-group">
					<label class="control-label col-xs-2">Module Name</label>
					<div class="col-xs-6">
						{!! Form::text('module_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.name'
								, 'placeholder' => 'Module Name'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Subject Name</label>
					<div class="col-xs-6">
						{!! Form::text('subject_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.subject'
								, 'placeholder' => 'Subject Name'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Area Name</label>
					<div class="col-xs-6">
						{!! Form::text('area_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.area'
								, 'placeholder' => 'Area Name'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('Search'
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'module.searchFnc($event)'
							)
						)!!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('Clear'
							,array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'module.clearFnc($event)'
							)
						)!!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="module-container">
		<div class="title-mid">
			module List
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
					'ng-model' => 'module.table.size'
					, 'ng-change' => 'module.paginateBySize()'
					, 'ng-if' => "module.records.length"
					, 'class' => 'form-control paginate-size pull-right'
				)
			) !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="module.list()">
		<div class="list-container" ng-cloak>
			<table id="module-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Module</th>
			            <th>Description</th>
			            <th>Subject</th>
			            <th>Area</th>
			            <th>Grade</th>
			            <th ng-if="module.records.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="moduleInfo in module.records">
			            <td>{! moduleInfo.name !}</td>
			            <td>{! moduleInfo.description !}</td>
			            <td>{! moduleInfo.subject !}</td>
			            <td>{! moduleInfo.subjectarea !}</td>
			            <td>{! moduleInfo.grade.name !}</td>
			            <td ng-if="module.records.length">
			            	<div class="row">
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.details(moduleInfo.id, futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.details(moduleInfo.id, futureed.ACTIVE_EDIT)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.details(moduleInfo.id, futureed.ACTIVE_EDIT)"><span><i class="fa fa-trash"></i></span></a>
			            		</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!module.records.length && !module.table.loading">
			        	<td valign="top" colspan="7">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="module.table.loading">
			        	<td valign="top" colspan="7">
			        		Loading...
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="module.records.length">
				<pagination 
					total-items="module.table.total_items" 
					ng-model="module.table.page"
					max-size="3"
					items-per-page="module.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="module.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>