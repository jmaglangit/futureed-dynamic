<div ng-if="subject.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_subject_mngt') !!}</span>
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

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-inline'
					, 'ng-submit' => 'subject.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-6">
					{!! Form::text('search_subject', ''
						,array(
							'placeholder' => 'trans('messages.name')'
							, 'ng-model' => 'subject.search.name'
							, 'class' => 'form-control btn-fit'
						)
					)!!}
				</div>
				
				<div class="col-xs-3">
					{!! Form::button('trans('messages.search')'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'subject.searchFnc($event)'
						)
					)!!}
				</div>
				<div class="col-xs-3">
					{!! Form::button('trans('messages.clear')'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'subject.clear()'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-semi-medium" ng-click="subject.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_subject') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_subject_list') !!}
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
						'ng-model' => 'subject.table.size'
						, 'ng-change' => 'subject.paginateBySize()'
						, 'ng-if' => "subject.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>
			
			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.admin_subject_code') !!}</th>
						<th>{!! trans('messages.admin_subject_name') !!}</th>
						<th ng-if="subject.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in subject.records">
						<td>{! record.code !}</td>
						<td class="td-fix">{! record.name !}</td>
						<td class="table-action">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa" 
										ng-class="{ 'fa-ban error-icon' : record.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : record.status == futureed.ENABLED }"
										tooltip="{! record.status !}"
										tooltip-placement="top"
										tooltip-trigger="mouseenter"></i>
								</div>
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="subject.setSubjectAreaDetails(record.id, record.name)"><span><i class="fa fa-plus"></i></span> {!! trans('messages.area') !!}</a>
								</div>
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="subject.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								
								<div class="col-xs-3">
									<a href="javascript:void(0)" ng-click="subject.confirmDeleteSubject(record.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>	
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!subject.records.length && !subject.table.loading">
						<td valign="top" colspan="4">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="subject.table.loading">
						<td valign="top" colspan="4">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="subject.records.length">
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