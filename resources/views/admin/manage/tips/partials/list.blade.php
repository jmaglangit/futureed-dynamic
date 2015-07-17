<div ng-if="tips.active_list">
	<div class="col-xs-12" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
			<p ng-repeat="error in tips.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="tips.success">
            <p>{! tips.success !}</p>
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
					, 'ng-submit' => 'tips.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Module'
							, 'ng-model' => 'tips.search.module'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'tips.search.subject'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'tips.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_area', ''
						,array(
							'placeholder' => 'Area'
							, 'ng-model' => 'tips.search.area'
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
							, 'ng-model' => 'tips.search.status'
						)
					) !!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'tips.clearFnc($event)'
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
							, 'ng-model' => 'tips.search.link_type'
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
						'ng-model' => 'tips.table.size'
						, 'ng-change' => 'tips.paginateBySize()'
						, 'ng-if' => "tips.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive" ng-init="tips.listTips()">
				<table id="tip-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Displayed At</th>
				            <th>Module</th>
				            <th>Subject</th>
				            <th>Area</th>
				            <th>Title</th>
				            <th>Status</th>
				            <th ng-if="tips.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="tipInfo in tips.records">
				            <td>{! tipInfo.link_type !}</td>
				            <td>{! tipInfo.module.name !}</td>
				            <td>{! tipInfo.subject.name !}</td>
				            <td>{! tipInfo.subjectarea.name !}</td>
				            <td>{! tipInfo.title !}</td>
				            <td>{! tipInfo.tip_status !}</td>
				            <td ng-if="tips.records.length">
				            	<div class="row">
				            		<div class="col-xs-4">
				            			<a href="" ng-click="tips.setActive(futureed.ACTIVE_VIEW, tipInfo.id)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="tips.setActive(futureed.ACTIVE_EDIT, tipInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="tips.confirmDelete(tipInfo.id)"><span><i class="fa fa-trash"></i></span></a>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!tips.records.length && !tips.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="tips.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="tips.records.length">
				<pagination 
					total-items="tips.table.total_items" 
					ng-model="tips.table.page"
					max-size="3"
					items-per-page="tips.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="tips.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>