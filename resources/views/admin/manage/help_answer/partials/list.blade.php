<div ng-if="answer.active_list">
	<div class="col-xs-12 success-container" ng-if="answer.errors || answer.success">
		<div class="alert alert-error" ng-if="answer.errors">
			<p ng-repeat="error in answer.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="answer.success">
            <p>{! answer.success !}</p>
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
					, 'ng-submit' => 'answer.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Module'
							, 'ng-model' => 'answer.search.module'
							, 'class' => 'form-control'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'answer.search.subject'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'answer.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_area', ''
						,array(
							'placeholder' => 'Area'
							, 'ng-model' => 'answer.search.area'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => '-- Select Status --'
							, 'Pending' => 'Pending'
							, 'Verified' => 'Verified'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'answer.search.status'
						)
					) !!}
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'answer.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('help_request', ''
						,array(
							'placeholder' => 'Help Request'
							, 'ng-model' => 'answer.search.help_request'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="title-mid">
			Help Answer List
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
						'ng-model' => 'answer.table.size'
						, 'ng-change' => 'answer.paginateBySize()'
						, 'ng-if' => "answer.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive">
				<table id="grade-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Displayed At</th>
				            <th>Module</th>
				            <th>Subject</th>
				            <th>Area</th>
				            <th>Title</th>
				            <th>Status</th>
				            <th ng-if="answer.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="tipInfo in answer.records">
				            <td>{! tipInfo.code !}</td>
				            <td>{! tipInfo.name !}</td>
				            <td>{! tipInfo.description !}</td>
				            <td>{! tipInfo.code !}</td>
				            <td>{! tipInfo.name !}</td>
				            <td>{! tipInfo.description !}</td>
				            <td ng-if="answer.records.length">
				            	<div class="row">
				            		<div class="col-xs-4">
				            			<a href="" ng-click="answer.setActive(futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="answer.setActive(futureed.ACTIVE_EDIT)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click=""><span><i class="fa fa-trash"></i></span></a>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!answer.records.length && !answer.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="answer.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="answer.records.length">
				<pagination 
					total-items="answer.table.total_items" 
					ng-model="answer.table.page"
					max-size="3"
					items-per-page="answer.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="answer.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>