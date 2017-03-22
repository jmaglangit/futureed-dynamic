<div ng-if="template.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.template') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="template.errors || template.success">
		<div class="alert alert-error" ng-if="template.errors">
			<p ng-repeat="error in template.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="template.success">
			<p>{! template.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'template.searchFnc($event)'
					]
			) !!}
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::select('question_type'
							, array(
								'' =>trans('messages.admin_question_type')
								, 'FIB' => trans('messages.admin_question_type_fib')
								, 'MC' => trans('messages.admin_question_type_mc')
							)
							, null
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'template.search.question_type'
								, 'placeholder' => trans('messages.email'))
						) !!}
					</div>
					<div class="col-xs-5">
						{!! Form::select('question_form'
							, array(
								'' =>trans('messages.admin_question_form')
								, 'Word' => trans('messages.admin_question_form_word')
								, 'Blank' => trans('messages.admin_question_form_blank')
								, 'Series' => trans('messages.admin_question_form_series')
							)
							, null
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'template.search.question_form'
								, 'placeholder' => trans('messages.email'))
						) !!}
					</div>
					<div class="col-xs-2 admin-search-template">
						{!! Form::button(trans('messages.search')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.searchFnc($event)'
							)
						)!!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::select('operation'
							, array(
								'' =>trans('messages.admin_operation')
								, 'Add' => trans('messages.admin_operation_add')
							)
							, null
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'template.search.operation'
								, 'placeholder' => trans('messages.email'))
						) !!}
					</div>
					<div class="col-xs-5">
						{!! Form::text('question_template_format', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'template.search.question_template_format'
								, 'placeholder' => trans('messages.admin_template_text')
							)
						) !!}
					</div>
					<div class="col-xs-2 admin-search-template">
						{!! Form::button(trans('messages.clear')
							,array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'template.clearFnc($event)'
							)
						)!!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="template.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_template') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_template_list') !!}
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
						'ng-model' => 'template.table.size'
						, 'ng-change' => 'template.paginateBySize()'
						, 'ng-if' => "template.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans_choice('messages.admin_question_type', 1) !!}</th>
						<th>{!! trans('messages.admin_operation') !!}</th>
						<th>{!! trans('messages.admin_question_form') !!}</th>
						<th>{!! trans_choice('messages.admin_template_text', 1) !!}</th>
						<th ng-if="template.records.length">{!! trans_choice('messages.action', 2) !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in template.records">
						<td>{! record.question_type !}</td>
						<td>{! record.operation !}</td>
						<td>{! record.question_form !}</td>
						<td>{! record.question_template_format !}</td>
						<td ng-if="template.records.length">
							<div class="row">
								<div class="col-xs-3">
									<a href="" ng-click="template.setActive(futureed.ACTIVE_VIEW, record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_view_template') !!}"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-3">
									<a href="" ng-click="template.setActive(futureed.ACTIVE_EDIT, record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_edit_template') !!}"><span><i class="fa fa-pencil"></i></span></a>
								</div>

								<div class="col-xs-3">
									<a href="" ng-click="template.confirmDelete(record.id)" tooltip-directive data-toggle="tooltip" title="{!! trans('messages.admin_delete_template') !!}"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!template.records.length && !template.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="template.table.loading && !template.records.length">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="template.records.length">
				<pagination 
					total-items="template.table.total_items" 
					ng-model="template.table.page"
					max-size="3"
					items-per-page="template.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="template.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="delete_template_modal" ng-show="template.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_delete_template') !!}
				</div>
				<div class="modal-body">
					{!! trans('messages.admin_delete_template_msg') !!}
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button(trans('messages.yes')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'template.deletetemplate()'
								, 'data-dismiss' => 'modal'
							)
						) !!}

						{!! Form::button(trans('messages.no')
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