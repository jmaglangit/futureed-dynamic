<div ng-if="tips.help_ans_active_list">
	<div class="col-xs-12" ng-if="tips.help_ans_errors || tips.help_ans_success">
		<div class="alert alert-error" ng-if="tips.help_ans_errors">
			<p ng-repeat="error in tips.help_ans_errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="tips.help_ans_success">
            <p>{! tips.help_ans_success !}</p>
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
					, 'ng-submit' => 'tips.searchAnsFnc($event)'
				)
			)!!}
			<div class="form-group">
				<label class="control-label col-xs-2">Title</label>
				<div class="col-xs-4">
					{!! Form::text('search_title', ''
						,array(
							'placeholder' => 'Title'
							, 'ng-model' => 'tips.search.ans_title'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				<label class="control-label col-xs-2">Subject</label>
				<div class="col-xs-4">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'Subject'
							, 'ng-model' => 'tips.search.ans_subject'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Status</label>
				<div class="col-xs-4">
					{!! Form::select('search_status'
						, array(
							'' => '-- Select Status --'
							, 'Pending' => 'Pending'
							, 'Accepted' => 'Accepted'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.search.ans_status'
						)
					) !!}
				</div>
				<label class="control-label col-xs-2">Area</label>
				<div class="col-xs-4">
					{!! Form::text('search_area', ''
						,array(
							'placeholder' => 'Title'
							, 'ng-model' => 'tips.search.ans_area'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Created</label>
				<div class="col-xs-5">
					{!! Form::text('search_module', ''
						,array(
							'placeholder' => 'Created'
							, 'ng-model' => 'tips.search.ans_created'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'tips.searchAnsFnc($event)'
						)
					)!!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'tips.clearAnsFnc($event)'
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
			<div class="table-responsive">
				<table id="help-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Title</th>
				            <th>Answer</th>
				            <th>Created By</th>
				            <th>Time Created</th>
				            <th>Time of Last Answer</th>
				            <th>Status</th>
				            <th ng-if="tips.help_ans_records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="helpAnsInfo in tips.help_ans_records">
				            <td>{! helpAnsInfo.help_request.title !}</td>
				            <td>{! helpAnsInfo.content !}</td>
				            <td>{! helpAnsInfo.user.name !}</td>
				            <td>{! helpAnsInfo.help_request.created_at !}</td>
				            <td>{! helpAnsInfo.help_request.last_answered_at !}</td>
				            <td>{! helpAnsInfo.request_answer_status !}</td>
				            <td ng-if="tips.help_ans_records.length">
				            	<div class="row">
				            		<div class="col-xs-6">
				            			<a href="" ng-click="tips.setHelpAnsActive(futureed.ACTIVE_VIEW, helpAnsInfo.id)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-6">
				            			<a href="" ng-click="tips.setHelpAnsActive(futureed.ACTIVE_EDIT, helpAnsInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!tips.help_ans_records.length && !tips.table.loading">
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
			<div class="pull-right" ng-if="tips.help_ans_records.length">
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