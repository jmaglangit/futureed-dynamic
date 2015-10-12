<div ng-if="grade.active_list_grade">
	<div class="content-title">
		<div class="title-main-content">
			<span>Grade Management</span>
		</div>
	</div>

	<div class="form-content col-xs-12" ng-if="grade.delete.success">
		<div class="alert alert-success">
	    	<p>Successfully deleted the selected grade.</p>
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
					, 'class' => 'form-inline'
					, 'ng-submit' => 'grade.searchFnc($event)'
					)
				)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_grade', ''
						,array(
							'placeholder' => 'Grade'
							, 'ng-model' => 'grade.search.grade'
							, 'class' => 'form-control btn-fit'
							, 'autocomplete' => 'off'
						)
					)!!}
				</div>

				<div class="col-xs-5">
	        		<select ng-init="getCountries()" name="country_id" class="form-control" ng-model="grade.search.country_id">
		          		<option ng-selected="grade.search.country_id == 'all'" value="">-- Select Country --</option>
		          		<option ng-selected="grade.search.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	        		</select>
	        	</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'grade.searchFnc()'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
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
		<button class="btn btn-blue btn-small" ng-click="grade.setActive('add_grade')">
			<i class="fa fa-plus-square"></i> Add Grade
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				Grade List
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
						, 'ng-if' => "grade.grades.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12  table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>Grade Code</th>
		            <th>Grade</th>
		            <th>Country</th>
		            <th ng-if="grade.grades.length">Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="a in grade.grades">
		            <td>{! a.code !}</td>
		            <td>{! a.name !}</td>
		            <td>{! a.country.name !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
		            			<i class="fa" 
		            				ng-class="{ 'fa-ban error-icon' : a.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : a.status == futureed.ENABLED }"
		            				tooltip="{! a.status !}"
		            				tooltip-placement="top"
		            				tooltip-trigger="mouseenter"></i>
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="grade.getGradeDetails(a.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            		
		            		<div class="col-xs-4">
		            			<a href="" ng-click="grade.confirmDeleteGrade(a.id)"><span><i class="fa fa-trash"></i></span></a>
		            		</div>	
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!grade.grades.length && !grade.table.loading">
			        	<td valign="top" colspan="5">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="grade.table.loading">
			        	<td valign="top" colspan="5">
			        		Loading...
			        	</td>
			        </tr>
	        </tbody>

			</table>

			<div class="pull-right" ng-if="grade.grades.length">
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