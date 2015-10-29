<div ng-if="subject.active_view && area.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Subject Area Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="area.errors || area.success">
		<div class="alert alert-error" ng-if="area.errors">
			<p ng-repeat="error in area.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="area.success">
			<p>{! area.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-inline'
					, 'ng-submit' => 'area.searchFnc($event)'
				)
			) !!}
			<div class="form-group">
				<div class="col-xs-6">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Area'
							, 'ng-model' => 'area.search.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-3">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'area.searchFnc($event)'
						)
					)!!}
				</div>
				<div class="col-xs-3">
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
	 
	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="area.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Subject Area
		</button>

		<button class="btn btn-gold btn-semi-medium pull-right" ng-click="subject.setActive()">
			Back to Subject
		</button>

		<div class="list-container" ng-init="area.setActive()" ng-cloak>
			<div class="col-xs-6 title-mid">
				Subject Area List
			</div>

			<div class="col-xs-6 size-container">
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

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Area Code</th>
			            <th>Area</th>
			            <th ng-if="area.records.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="record in area.records">
			            <td>{! record.code !}</td>
			            <td>{! record.name !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-4">
			            			<i class="fa" 
			            				ng-class="{ 'fa-ban error-icon' : record.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : record.status == futureed.ENABLED }"
			            				tooltip="{! record.status !}"
			            				tooltip-placement="top"
			            				tooltip-trigger="mouseenter"></i>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="area.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		
			            		<div class="col-xs-4">
			            			<a href="" ng-click="area.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
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