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
			{!! trans('messages.search') !!}
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
							'placeholder' => trans_choice('messages.module', 1)
							, 'ng-model' => 'answer.search.module'
							, 'class' => 'form-control'
						)
					)!!}
				</div>

				<div class="col-xs-5">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => trans('messages.subject')
							, 'ng-model' => 'answer.search.subject'
							, 'class' => 'form-control'
							, 'autocomplete' => 'off'
						)
					)!!}
				</div>
				
				<div class="col-xs-2 admin-help-answer-list">
					{!! Form::button(trans('messages.search')
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'answer.searchFnc($event)'
						)
					)!!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-5">
					{!! Form::text('search_subject_area', ''
						,array(
							'placeholder' => trans('messages.area')
							, 'ng-model' => 'answer.search.subject_area'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
				
				<div class="col-xs-5">
					{!! Form::select('search_request_answer_status'
						, array(
							'' => trans('messages.admin_select_status')
							, 'Pending' => trans('messages.pending')
							, 'Accepted' => trans('messages.accepted')
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'answer.search.request_answer_status'
						)
					) !!}
				</div>
				
				<div class="col-xs-2 admin-help-answer-list">
					{!! Form::button(trans('messages.clear')
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
							'placeholder' => trans('messages.help_request')
							, 'ng-model' => 'answer.search.help_request'
							, 'class' => 'form-control'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="table-container" ng-init="answer.list()">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_help_answer_list') !!}
			</div>

			<div class="col-xs-6 size-container">
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

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>{!! trans('messages.module') !!}</th>
			            <th>{!! trans('messages.subject') !!}</th>
			            <th>{!! trans('messages.area') !!}</th>
			            <th>{!! trans('messages.help_request') !!}</th>
			            <th>{!! trans('messages.answer') !!}</th>
			            <th>{!! trans('messages.status') !!}</th>
			            <th ng-if="answer.records.length">{!! trans('messages.action') !!}</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="answerInfo in answer.records">
			            <td>{! answerInfo.module.name !}</td>
			            <td>{! answerInfo.subject.name !}</td>
			            <td>{! answerInfo.subject_area.name !}</td>
			            <td>{! answerInfo.help_request.title !}</td>
			            <td>{! answerInfo.content !}</td>
			            <td>{! answerInfo.request_answer_status !}</td>
			            <td ng-if="answer.records.length">
			            	<div class="row">
			            		<div class="col-xs-4">
			            			<a href="" ng-click="answer.setActive(futureed.ACTIVE_VIEW, answerInfo.id)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="answer.setActive(futureed.ACTIVE_EDIT, answerInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="answer.confirmDelete(answerInfo.id)"><span><i class="fa fa-trash"></i></span></a>
			            		</div>	
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!answer.records.length && !answer.table.loading">
			        	<td valign="top" colspan="7">
			        		{!! trans('messages.no_records_found') !!}
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="answer.table.loading">
			        	<td valign="top" colspan="7">
			        		{!! trans('messages.loading') !!}
			        	</td>
			        </tr>
		        </tbody>
			</table>

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