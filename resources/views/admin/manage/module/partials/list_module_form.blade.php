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
					<div class="col-xs-5" ng-init="module.getSubject()">
						<select ng-model="module.search.subject" ng-disabled="!module.subjects.length" class="form-control">
							<option value=""> -- Select Subject -- </option>
							<option ng-repeat="subject in module.subjects" ng-value="subject.name"> {! subject.name !} </option>
						</select>
					</div>
					<div class="col-xs-5">
						{!! Form::text('area_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.area'
								, 'placeholder' => 'Subject Area'
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
				</div>
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::text('module_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.name'
								, 'placeholder' => 'Module Name'
							)
						) !!}
					</div>
					<div class="col-xs-5"></div>
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
	<div class="clearfix"></div>
	<button class="btn btn-blue btn-small margin-0-30" ng-click="module.setActive('add')">
		<i class="fa fa-plus-square"></i> Add Module
	</button>

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

	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="module-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Module</th>
			            <th>Subject</th>
			            <th>Area</th>
			            <th ng-if="module.records.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="moduleInfo in module.records">
			            <td class="wide-column">{! moduleInfo.name !}</td>
			            <td>{! moduleInfo.subject.name !}</td>
			            <td>{! moduleInfo.subject_area.name !}</td>
			            <td ng-if="module.records.length">
			            	<div class="row">
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.setActive(futureed.ACTIVE_VIEW, moduleInfo.id)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.setActive(futureed.ACTIVE_EDIT, moduleInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="module.confirmDelete(moduleInfo.id)"><span><i class="fa fa-trash"></i></span></a>
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

<div id="delete_module_modal" ng-show="module.delete.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Delete Module
        </div>
        <div class="modal-body">
            Are you sure you want to delete this module?
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'module.deleteModule()'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button('No'
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}
        	</div>
        </div>
    </div>
  </div>
</div>