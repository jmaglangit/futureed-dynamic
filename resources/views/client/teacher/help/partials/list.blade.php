<div ng-if="help.active_list">
	<div class="col-xs-12" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
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
					, 'ng-submit' => 'help.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_title', ''
						,array(
							'placeholder' => 'Title'
							, 'ng-model' => 'help.search.title'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::select('search_status'
						, array(
							'' => '-- Select Help Request Status --'
							, 'Pending' => 'Pending'
							, 'Accepted' => 'Accepted'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'help.search.request_status'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'help.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'help.search.subject'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-5">
					{!! Form::text('search_subject_area', ''
						,array(
							'placeholder' => 'Subject Area'
							, 'ng-model' => 'help.search.subject_area'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'help.clearFnc()'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_created', ''
						,array(
							'placeholder' => 'Created'
							, 'ng-model' => 'help.search.created'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<div class="title-mid">
			Help Request List
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
						'ng-model' => 'help.table.size'
						, 'ng-change' => 'help.paginateBySize()'
						, 'ng-if' => "help.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive">
				<table id="help-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Title</th>
				            <th>Description</th>
				            <th>Created By</th>
				            <th>Time Created</th>
				            <th>Time of Last Answer</th>
				            <th>Status</th>
				            <th ng-if="help.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="helpInfo in help.records">
				            <td>{! helpInfo.title !}</td>
				            <td class="wide-column">{! helpInfo.content !}</td>
				            <td>{! helpInfo.student.first_name !} {! helpInfo.student.last_name !}</td>
				            <td>{! helpInfo.created_at | ddMMyy !}</td>
				            <td>{! helpInfo.last_answered_at | ddMMyy : '-' !}</td>
				            <td>{! helpInfo.request_status !}</td>
				            <td ng-if="help.records.length">
				            	<div class="row">
				            		<div class="col-xs-6">
				            			<a href="" ng-click="help.setActive(futureed.ACTIVE_VIEW, helpInfo.id)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-6">
				            			<a href="" ng-click="help.setActive(futureed.ACTIVE_EDIT, helpInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!help.records.length && !help.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="help.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="help.records.length">
				<pagination 
					total-items="help.table.total_items" 
					ng-model="help.table.page"
					max-size="3"
					items-per-page="help.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="help.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>