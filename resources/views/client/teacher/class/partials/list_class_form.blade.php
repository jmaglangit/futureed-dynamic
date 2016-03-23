<div ng-if="class.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.class_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="class.errors || class.success">
		<div class="alert alert-error" ng-if="class.errors">
            <p ng-repeat="error in class.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="class.success">
            <p>{! class.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'class.searchFnc($event)'
					)
			) !!}
				<div class="form-group">
					<div class="col-xs-4">
						{!! Form::text('name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'class.search.name'
								, 'placeholder' => 'trans('messages.class_name')'
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>
					<div class="col-xs-4">
	                    <select ng-init="class.getGradeLevel(user.country_id)" 
	                    	name="grade_id" 
	                    	class="form-control" 
	                    	ng-disabled="!class.grades.length"
	                    	ng-model="class.search.grade_id">
	                        <option value="">{!! trans('messages.select_level') !!}</option>
	                        <option ng-repeat="grade in class.grades" ng-value="grade.id">{! grade.name !}</option>
	                    </select>
	                </div>
					<div class="col-xs-2">
						{!! Form::button('trans('messages.search')', 
							array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'class.searchFnc($event)'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('trans('messages.clear')', 
							array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'class.clear()'
							)
						) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="class.list()">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.class_list') !!}
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
						'ng-model' => 'class.table.size'
						, 'ng-change' => 'class.paginateBySize()'
						, 'ng-if' => "class.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>{!! trans('messages.grade') !!}</th>
		            <th>{!! trans('messages.class_name') !!}</th>
		            <th>{!! trans('messages.no_of_seats_taken') !!}</th>
		            <th>{!! trans('messages.no_of_seats_enrolled') !!}</th>
		            <th ng-if="class.records.length">{!! trans('messages.action') !!}</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="classInfo in class.records">
		            <td>{! classInfo.grade.name !}</td>
		            <td>{! classInfo.name !}</td>
		            <td>{! classInfo.seats_taken !}</td>
		            <td>{! classInfo.seats_total !}</td>
		            <td ng-if="class.records.length">
		            	<div class="row">
		            		<div class="col-xs-4">
		            			{! classInfo.status !}
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="class.setActive('view',classInfo.id)"><span><i class="fa fa-eye"></i></span></a>
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="class.setActive('edit', classInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            	</div>
		            </td>
        		</tr>
        		<tr class="odd" ng-if="!class.records.length && !class.table.loading">
		        	<td valign="top" colspan="4">
		        		{!! trans('messages.no_records_found') !!}
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="class.table.loading">
		        	<td valign="top" colspan="4">
		        		{!! trans('messages.loading') !!}
		        	</td>
		        </tr>
	        	</tbody>
			</table>

			<div class="pull-right" ng-if="class.records.length">
				<pagination 
					total-items="class.table.total_items" 
					ng-model="class.table.page"
					max-size="3"
					items-per-page="class.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="class.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>