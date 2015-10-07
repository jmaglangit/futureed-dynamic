<div ng-if="logs.active_list">
	<div class="col-xs-12" ng-if="logs.errors || logs.success">
		<div class="alert alert-error" ng-if="logs.errors">
			<p ng-repeat="error in logs.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="logs.success">
            <p>{! logs.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'logs.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Module'
							, 'ng-model' => 'logs.search.module'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'logs.search.subject'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'logs.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_area', ''
						,array(
							'placeholder' => 'Area'
							, 'ng-model' => 'logs.search.area'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => '-- Select Status --'
							, 'Pending' => 'Pending'
							, 'Accepted' => 'Accepted'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.status'
						)
					) !!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'logs.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-3"></div>
				<label class="col-xs-2 control-label">Displayed At</label>
				<div class="col-xs-5">
					{!! Form::select('search_link_type'
						, array(
							'' => '-- Select Type --'
							, 'General' => 'General'
							, 'Content' => 'Content'
							, 'Question' => 'Question'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'logs.search.link_type'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="title-mid">
			Tip List
		</div>

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
						'ng-model' => 'logs.table.size'
						, 'ng-change' => 'logs.paginateBySize()'
						, 'ng-if' => "logs.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive" ng-init="logs.list()">
				<table id="tip-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Displayed At</th>
				            <th>Module</th>
				            <th>Subject</th>
				            <th>Area</th>
				            <th>Title</th>
				            <th>Status</th>
				            <th ng-if="logs.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="tipInfo in logs.records">
				            <td>{! tipInfo.link_type !}</td>
				            <td>{! tipInfo.module.name !}</td>
				            <td>{! tipInfo.subject.name !}</td>
				            <td>{! tipInfo.subjectarea.name !}</td>
				            <td>{! tipInfo.title !}</td>
				            <td>{! tipInfo.tip_status !}</td>
				            <td ng-if="logs.records.length">
				            	<div class="row">
				            		<div class="col-xs-4">
				            			<a href="" ng-click="logs.setActive(futureed.ACTIVE_VIEW, tipInfo.id)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="logs.setActive(futureed.ACTIVE_EDIT, tipInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="logs.confirmDelete(tipInfo.id)"><span><i class="fa fa-trash"></i></span></a>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!logs.records.length && !logs.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="logs.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="logs.records.length">
				<pagination 
					total-items="logs.table.total_items" 
					ng-model="logs.table.page"
					max-size="3"
					items-per-page="logs.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="logs.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>