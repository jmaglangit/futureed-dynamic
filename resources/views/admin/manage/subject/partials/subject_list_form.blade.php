<div ng-if="subject.active_list_subject">
	<div class="content-title">
		<div class="title-main-content">
			<span>Subject Management</span>
		</div>
	</div>
			
	<div class="form-content" ng-if="subject.delete.success">		
		<div class="alert alert-success">
	    	<p>Successfully deleted the selected subject.</p>
	    </div>
	</div>

	<div class="form-content col-xs-12">
	    <div class="col-xs-3" style="padding:0;">
			<div class="btn btn-gold" ng-click="subject.setManageSubjectActive('add_subject')">
				<div class="row">
					<i class="fa fa-plus-square"></i>
				</div>
				<div class="row">
					Add Subject
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
				<div class="col-xs-8">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Name'
							, 'ng-model' => 'subject.search.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'subject.getSubjectList()'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn'
							, 'ng-click' => 'subject.clearSearchForm()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="title-mid">
			Client List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Subject Code</th>
		            <th>Subject Name</th>
		            <th>Description</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="a in subject.subjects">
		            <td>{! a.code !}</td>
		            <td>{! a.name !}</td>
		            <td>{! a.description !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
		            			{! a.status !}
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click=""><span><i class="fa fa-plus"></i></span> Add Area</a>
		            		</div>
		            		<div class="col-xs-2">
		            			<a href="" ng-click="subject.getSubjectDetails(a.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            		
		            		<div class="col-xs-2">
		            			<a href="" ng-click="subject.confirmDeleteSubject(a.id)"><span><i class="fa fa-trash"></i></span></a>
		            		</div>	
		            	</div>
		            </td>
		        </tr>
	        </tbody>

			</table>
		</div>
	</div>
</div>