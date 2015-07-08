<div ng-if="help.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span><i class="fa fa-lightbulb-o"></i> General help</span>
		</div>
	</div>

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
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'help.search.subject'
							, 'class' => 'form-control'
							, 'autocomplete' => 'off'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::select('search_question_status'
						, array(
							'' => '-- Select Status --'
							, 'Open' => 'Open'
							, 'Answered' => 'Answered'
							, 'Cancelled' => 'Cancelled'
						), ''
						, array(
							  'ng-model' => 'help.search.question_status'
							, 'class' => 'form-control'
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
					{!! Form::select('search_help_request_type'
						, array(
							  'All' => 'All'
							, 'Own' => 'Your Requests'
							, 'Others' => 'Other Requests'
						), '$request_type'
						, array(
							  'ng-model' => 'help.search.help_request_type'
							, 'class' => 'form-control'
						)
					) !!}
				</div>

				<div class="col-xs-5">
				</div>

				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'help.clearFnc($event)'
						)
					)!!}
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
						'ng-model' => 'help.table.size'
						, 'ng-change' => 'help.paginateBySize()'
						, 'ng-if' => "help.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive" ng-init="help.listHelp()">
				<table id="tip-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>help</th>
				            <th>Subject</th>
				            <th>Area</th>
				            <th>Posted Since</th>
				            <th>Posted By</th>
				            <th ng-if="help.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="tipInfo in help.records">
				            <td>{! tipInfo.title !}</td>
				            <td>{! tipInfo.subject.name !}</td>
				            <td>{! tipInfo.subjectarea.name !}</td>
				            <td>{! tipInfo.created_at | ddMMyy !}</td>
				            <td>{! tipInfo.student.first_name !} {! tipInfo.student.last_name !}</td>
				            <td ng-if="help.records.length">
				            	<div class="row">
				            		<div class="col-xs-12">
				            			<a href="" ng-click="help.setActive(futureed.ACTIVE_VIEW, tipInfo.id)"><span><i class="fa fa-eye"></i></span></a>
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