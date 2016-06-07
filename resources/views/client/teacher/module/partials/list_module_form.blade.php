<div ng-if="module.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_module_mgmt') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{{ trans('messages.search') }}
		</div>

		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'module.searchFnc($event)'
					)
			) !!}
				<div class="form-group">
					<div class="col-xs-6" ng-init="module.getGradeLevel(user.country_id);">
	                    <select name="grade_id" class="form-control" ng-disabled="!module.grades.length" ng-model="module.search.grade_id">
	                        <option value="">{!! trans('messages.select_level') !!}</option>
	                        <option ng-repeat="grade in module.grades" ng-value="grade.id">{! grade.name !}</option>
	                    </select>
	                </div>
	                <div class="col-xs-6">
						{!! Form::text('name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'module.search.name'
								, 'placeholder' => trans('messages.admin_module_name')
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6" ng-init="module.getSubject()">
	                    <select name="grade_id" class="form-control" ng-disabled="!module.subjects.length" ng-model="module.search.subject">
	                        <option value="">{!! trans('messages.select_subject') !!}</option>
	                        <option ng-repeat="subject in module.subjects" ng-value="subject.name">{! subject.name !}</option>
	                    </select>
	                </div>
					<div class="col-xs-3">
						{!! Form::button(trans('messages.search'),
							array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'module.searchFnc($event)'
							)
						) !!}
					</div>
					<div class="col-xs-3">
						{!! Form::button(trans('messages.clear'),
							array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'module.clearFnc()'
							)
						) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_module_list') !!}
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
						'ng-model' => 'module.table.size'
						, 'ng-change' => 'module.paginateBySize()'
						, 'ng-if' => "module.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>{!! trans_choice('messages.module', 1) !!}</th>
		            <th>{!! trans_choice('messages.grade', 1) !!}</th>
		            <th ng-if="module.records.length">{!! trans_choice('messages.action', 1) !!}</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="info in module.records">
		            <td>{! info.name !}</td>
		            <td>{! info.grade.name !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-6">
		            			<a href="javascript:void(0)" ng-click="module.launchModule('{!! route('client.teacher.teaching_content.index') !!}', info.id)" title="launch">{!! trans('messages.launch') !!}</a>
		            		</div>
		            		<div class="col-xs-6">
		            			<a href="javascript:void(0)" ng-click="module.setActive(futureed.ACTIVE_VIEW ,info.id)" title="view"><span><i class="fa fa-eye"></i></span></a>
		            		</div>
		            	</div>
		            </td>
        		</tr>
        		<tr class="odd" ng-if="!module.records.length && !module.table.loading">
		        	<td valign="top" colspan="4">
		        		{!! trans('messages.no_records_found') !!}
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="module.table.loading">
		        	<td valign="top" colspan="4">
		        		{!! trans('messages.loading') !!}
		        	</td>
		        </tr>
	        	</tbody>
			</table>

			<div class="pull-right" ng-if="module.records.length">
				<pagination 
					total-items="module.table.total_items" 
					ng-model="module.table.page"
					max-size="3"
					items-per-page="module.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="module.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>