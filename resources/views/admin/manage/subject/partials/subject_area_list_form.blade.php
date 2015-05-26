<div ng-if="subject.subject_area_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Subject Management</span>
		</div>
	</div>

	<div class="form-content col-xs-12">
        <div class="alert alert-success" ng-if="subject.delete_area.success">
	    	<p>Successfully deleted the selected subject area.</p>
	    </div>

        <div class="alert alert-success" ng-if="subject.create_area.success">
	    	<p>Successfully added new subject area.</p>
	    </div>

        <div class="alert alert-success" ng-if="subject.area_details.success">
	    	<p>Successfully updated the selected subject area.</p>
	    </div>

		<div template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_add_form') !!}"></div>
		<div template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_details_form') !!}"></div>
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
				<div class="col-xs-8">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Name'
							, 'ng-model' => 'subject.search_area.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'subject.getSubjectAreaList(subject.subject_id, subject.subject_name)'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn'
							, 'ng-click' => 'subject.clearSearchSubjectAreaForm()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="title-mid">
			Subject Area List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Area Code</th>
		            <th>Area</th>
		            <th>Description</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="a in subject.subject_areas">
		            <td>{! a.code !}</td>
		            <td>{! a.name !}</td>
		            <td>{! a.description !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
		            			{! a.status !}
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="subject.getSubjectAreaDetails(a.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            		
		            		<div class="col-xs-4">
		            			<a href="" ng-click="subject.confirmDeleteSubjectArea(a.id)"><span><i class="fa fa-trash"></i></span></a>
		            		</div>	
		            	</div>
		            </td>
		        </tr>
	        </tbody>

			</table>
		</div>
	</div>
</div>