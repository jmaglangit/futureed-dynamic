<div ng-if="content.active_list">
	<div class="col-xs-12 success-container" ng-if="content.errors || content.success">
		<div class="alert alert-error" ng-if="content.errors">
			<p ng-repeat="error in content.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="content.success">
			<p>{! content.success !}</p>
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
					, 'ng-submit' => 'content.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('search_teaching_module', ''
						,array(
							'placeholder' => trans('messages.admin_teaching_module_name')
							, 'ng-model' => 'content.search.teaching_module'
							, 'class' => 'form-control'
						)
					)!!}
				</div>

				<div class="col-xs-4 admin-view-module-content" ng-init="content.getLearningStyle()">
					<select  name="learning_style" class="form-control" ng-model="content.search.learning_style">
						<option value="">{!! trans('messages.select_learning_style') !!}</option>
						<option ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>
					</select>
				</div>
				
				<div class="col-xs-2 admin-search-module-content">
					{!! Form::button(trans('messages.search')
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'content.searchFnc($event)'
						)
					)!!}
				</div>

				<div class="col-xs-2 admin-search-module-content">
					{!! Form::button(trans('messages.clear')
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'content.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12 table-container" ng-init="content.list()">
		<button class="btn btn-blue btn-semi-medium" ng-click="content.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> {!! trans('messages.admin_add_content') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_content_list') !!}
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
						'ng-model' => 'content.table.size'
						, 'ng-change' => 'content.paginateBySize()'
						, 'ng-if' => "content.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.code') !!}</th>
						<th>{!! trans('messages.admin_teaching_module_name') !!}</th>
						<th>{!! trans('messages.learning_style') !!}</th>
						<th>{!! trans('messages.admin_media_type') !!}</th>
						<th ng-if="content.records.length">{!! trans('messages.action') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="record in content.records">
						<td>{! record.code !}</td>
						<td class="wide-column">{! record.teaching_module !}</td>
						<td>{! record.learning_style.name !}</td>
						<td>{! record.media_type.name !}</td>
						<td ng-if="content.records.length">
							<div class="row">
								<div class="col-xs-4">
									<a href="" ng-click="content.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="content.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="content.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>	
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!content.records.length && !content.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
					<tr class="odd" ng-if="content.table.loading">
						<td valign="top" colspan="7">
							{!! trans('messages.loading') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="content.records.length">
				<pagination 
					total-items="content.table.total_items" 
					ng-model="content.table.page"
					max-size="3"
					items-per-page="content.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="content.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>