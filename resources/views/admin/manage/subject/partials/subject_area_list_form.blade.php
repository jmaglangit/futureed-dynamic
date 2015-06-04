<div ng-if="subject_area_list || area.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Subject Area Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="area.delete_area.success">
            <div class="alert alert-success">
                <p>{! area.delete_area.success !}</p>
            </div>
    </div>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'method' => 'POST'
					, 'class' => 'form-inline'
					)
				)!!}
			<div class="form-group">
				<div class="col-xs-8">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Name'
							, 'ng-model' => 'area.search.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'area.searchFnc()'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'area.clear()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<button class="btn btn-blue btn-small margin-0-30" ng-click="area.setActive('add_subject_area')">
		<i class="fa fa-plus-square"></i> Add 
	</button>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Subject Area List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-init="area.setActive()" ng-cloak>
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
						'ng-model' => 'area.table.size'
						, 'ng-change' => 'area.paginateBySize()'
						, 'ng-if' => "area.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Area Code</th>
			            <th>Area</th>
			            <th>Description</th>
			            <th>Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="a in area.records">
			            <td>{! a.code !}</td>
			            <td>{! a.name !}</td>
			            <td>{! a.description !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-4">
			            			{! a.status !}
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="area.details(a.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		
			            		<div class="col-xs-4">
			            			<a href="" ng-click="area.confirmDelete(a.id)"><span><i class="fa fa-trash"></i></span></a>
			            		</div>	
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!area.records.length && !area.table.loading">
			        	<td valign="top" colspan="4">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="area.table.loading">
			        	<td valign="top" colspan="4">
			        		Loading...
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="area.records.length">
				<pagination 
					total-items="area.table.total_items" 
					ng-model="area.table.page"
					max-size="3"
					items-per-page="area.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="area.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>