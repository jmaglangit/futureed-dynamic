<div ng-if="qa.active_list">
	<div class="col-xs-12 success-container" ng-if="qa.errors || qa.success">
		<div class="alert alert-error" ng-if="qa.errors">
			<p ng-repeat="error in qa.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="qa.success">
			<p>{! qa.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'qa.searchFnc($event)'
					]
			) !!}
				<div class="form-group">
					<div class="col-xs-4">
						{!! Form::text('questions_text', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.search.questions_text'
								, 'placeholder' => 'trans('messages.admin_question_text')'
							)
						) !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('question_type'
							, array(
								'' => 'trans('messages.admin_select_question_type')'
								, 'MC' => 'trans('messages.admin_mc')'
								, 'FIB' => 'trans('messages.admin_fib')'
								, 'O' => 'trans('messages.admin_order')'
								, 'N' => 'trans('messages.admin_provide')'
								, 'GR' => 'trans('messages.admin_graph')'
								, 'QUAD' => 'trans('messages.admin_quadrant')'
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.search.question_type'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('trans('messages.search')'
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'qa.searchFnc($event)'
							)
						)!!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('trans('messages.clear')'
							,array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'qa.clearFnc($event)'
							)
						)!!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="qa.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_q_a') !!}
		</button>

		<div class="list-container">
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_question_list') !!}
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
						'ng-model' => 'qa.table.size'
						, 'ng-change' => 'qa.paginateBySize()'
						, 'ng-if' => "qa.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.code') !!}</th>
						<th>{!! trans('messages.admin_question_text') !!}</th>
						<th>{!! trans('messages.admin_question_image') !!}</th>
						<th>{!! trans('messages.admin_question_type') !!}</th>
						<th>{!! trans('messages.difficulty') !!}</th>
						<th ng-if="qa.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in qa.records">
						<td>{! record.code !}</td>
						<td class="wide-column">{! record.questions_text !}</td>
						<td><a href="javascript:;" ng-if="record.questions_image != futureed.NONE" ng-click="qa.viewImage(record)">{!! trans('messages.admin_view_image') !!}</a></td>
						<td>{! record.question_type !}</td>
						<td>{! record.difficulty !}</td>
						<td ng-if="qa.records.length">
							<div class="row">
								<div class="col-xs-4">
									<a href="" ng-click="qa.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="qa.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="qa.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!qa.records.length">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="qa.records.length">
				<pagination 
					total-items="qa.table.total_items" 
					ng-model="qa.table.page"
					max-size="3"
					items-per-pqa="qa.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="qa.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="delete_question_modal" ng-show="qa.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_delete_question') !!}
				</div>
				<div class="modal-body">
					{!! trans('messages.admin_delete_question_msg') !!}
				</div>
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button('trans('messages.yes')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'qa.deleteQuestion()'
								, 'data-dismiss' => 'modal'
							)
						) !!}

						{!! Form::button('trans('messages.no')'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'data-dismiss' => 'modal'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="qa_image_modal" ng-show="qa.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{! qa.view_image.questions_text !}
				</div>
				<div class="modal-body">
					<div class="modal-image">
						<img ng-src="{! qa.view_image.image_path !}"/>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button('trans('messages.close')'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'data-dismiss' => 'modal'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>