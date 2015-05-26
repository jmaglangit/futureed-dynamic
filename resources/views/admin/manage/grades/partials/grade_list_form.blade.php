<div ng-if="grade.active_list_grade">
	<div class="content-title">
		<div class="title-main-content">
			<span>Grade Management</span>
		</div>
	</div>

	<div class="form-content col-xs-12">
		<div class="alert alert-success" ng-if="grade.delete.success">
	    	<p>Successfully deleted the selected grade.</p>
	    </div>

	    <div class="col-xs-3" style="padding:0;">
			<div class="btn btn-gold" ng-click="grade.setManageGradeActive('add_grade')">
				<div class="row">
					<i class="fa fa-plus-square"></i>
				</div>
				<div class="row">
					Add Grade
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="title-mid">
			Search
		</div>
	</div>

	<div class="col-xs-12">
		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'method' => 'POST'
					, 'class' => 'form-inline'
					)
				)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_grade', ''
						,array(
							'placeholder' => 'Grade'
							, 'ng-model' => 'grade.search.grade'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

        		<select ng-init="getCountries()" name="country_id" class="form-control col-xs-3" ng-model="grade.search.country">
	          		<option value="">-- Select Country --</option>
	          		<option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
        		</select>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'grade.getGradeList()'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn'
							, 'ng-click' => 'grade.clearSearchForm()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="title-mid">
			Grade List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Grade Code</th>
		            <th>Grade</th>
		            <th>Description</th>
		            <th>Country</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="a in grade.grades">
		            <td>{! a.code !}</td>
		            <td>{! a.name !}</td>
		            <td>{! a.description !}</td>
		            <td>{! a.country.name !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
		            			<i ng-if="a.status == 'Disabled'" title="Enable" class="fa success-icon fa-check-circle-o"></i>
		            			<i ng-if="a.status == 'Enabled'" title="Disable" class="fa error-icon fa-ban"></i>
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
	        </tbody>

			</table>
		</div>
	</div>
</div>