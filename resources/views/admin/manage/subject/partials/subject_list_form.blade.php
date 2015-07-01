<div ng-if="subject.active_list_subject">
	<div class="content-title">
		<div class="title-main-content">
			<span>Subject Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="subject.errors || subject.success">
		<div class="alert alert-error" ng-if="subject.errors">
			<p ng-repeat="error in subject.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="subject.success">
            <p>{! subject.success !}</p>
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
					, 'ng-submit' => 'subject.searchFnc($event)'
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
							'class' => 'btn btn-blue'
							, 'ng-click' => 'subject.searchFnc($event)'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'subject.clear()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<button class="btn btn-blue btn-small margin-0-30" ng-click="subject.setManageSubjectActive('add_subject')">
		<i class="fa fa-plus-square"></i> Add Subject
	</button>

	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Subject List
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
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
						'ng-model' => 'subject.table.size'
						, 'ng-change' => 'subject.paginateBySize()'
						, 'ng-if' => "subject.subjects.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>
			<div class="clearfix"></div>
			<div class="table-responsive">
				<table id="grade-list" class="table table-striped table-bordered">
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
				            <td class="td-fix">{! a.name !}</td>
				            <td class="td-fix">{! a.description !}</td>
				            <td class="table-action">
				            	<div class="row">
				            		<div class="col-xs-4">
				            			{! a.status !}
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="subject.setSubjectAreaDetails(a.id, a.name)"><span><i class="fa fa-plus"></i></span> Area</a>
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
				        <tr class="odd" ng-if="!subject.subjects.length && !subject.table.loading">
				        	<td valign="top" colspan="4" class="dataTables_empty">
				        		No data available in table
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="subject.table.loading">
				        	<td valign="top" colspan="4" class="dataTables_empty">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="subject.subjects.length">
				<pagination 
					total-items="subject.table.total_items" 
					ng-model="subject.table.page"
					max-size="3"
					items-per-page="subject.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="subject.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>