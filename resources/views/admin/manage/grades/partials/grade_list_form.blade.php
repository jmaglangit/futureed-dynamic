<div ng-if="grade.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_grade_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="grade.errors || grade.success">
		<div class="alert alert-error" ng-if="grade.errors">
			<p ng-repeat="error in grade.errors track by $index" > 
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="grade.success">
			<p> 
				{! grade.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-inline'
					, 'ng-submit' => 'grade.searchFnc($event)'
					)
				)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_grade', ''
						,array(
							'placeholder' => 'trans('messages.grade')'
							, 'ng-model' => 'grade.search.grade'
							, 'class' => 'form-control btn-fit'
							, 'autocomplete' => 'off'
						)
					)!!}
				</div>

				<div class="col-xs-5">
	        		<select ng-init="getCountries()" name="country_id" class="form-control" ng-model="grade.search.country_id">
		          		<option ng-selected="grade.search.country_id == 'all'" value="">{!! trans('messages.select_country') !!}</option>
		          		<option ng-selected="grade.search.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	        		</select>
	        	</div>
				
				<div class="col-xs-2">
					{!! Form::button('trans('messages.search')'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'grade.searchFnc()'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.clear')'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'grade.clear()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="grade.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_grade') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_grade_list') !!}
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
						'ng-model' => 'grade.table.size'
						, 'ng-change' => 'grade.paginateBySize()'
						, 'ng-if' => "grade.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12  table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>{!! trans('messages.grade_code') !!}</th>
		            <th>{!! trans('messages.grade') !!}</th>
		            <th>{!! trans('messages.country') !!}</th>
		            <th ng-if="grade.records.length">{!! trans('messages.action') !!}</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="record in grade.records">
		            <td>{! record.code !}</td>
		            <td>{! record.name !}</td>
		            <td>{! record.country.name !}</td>
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
		            			<a href="" ng-click="grade.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            		
		            		<div class="col-xs-4">
		            			<a href="" ng-click="grade.confirmDeleteGrade(record.id)"><span><i class="fa fa-trash"></i></span></a>
		            		</div>	
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!grade.records.length && !grade.table.loading">
			        	<td valign="top" colspan="5">
			        		{!! trans('messages.no_records_found') !!}
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="grade.table.loading">
			        	<td valign="top" colspan="5">
			        		{!! trans('messages.loading') !!}
			        	</td>
			        </tr>
	        </tbody>

			</table>

			<div class="pull-right" ng-if="grade.records.length">
				<pagination 
					total-items="grade.table.total_items" 
					ng-model="grade.table.page"
					max-size="3"
					items-per-page="grade.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="grade.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>