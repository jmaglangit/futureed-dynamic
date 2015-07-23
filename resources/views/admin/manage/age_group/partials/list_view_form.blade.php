<div ng-if="age.active_list" id="age-group">
	<div class="col-xs-12 success-container" ng-if="age.errors || age.success">
		<div class="alert alert-error" ng-if="age.errors">
			<p ng-repeat="error in age.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="age.success">
            <p>{! age.success !}</p>
        </div>
    </div>

    <div class="col-xs-12"></div>
    <div class="col-xs-12" ng-if="false">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'age.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('search_teaching_module', ''
						,array(
							'placeholder' => 'Teaching Module'
							, 'ng-model' => 'age.search.teaching_module'
							, 'class' => 'form-control'
						)
					)!!}
				</div>

				<div class="col-xs-4" ng-init="age.getLearningStyle()">
					<select  name="learning_style" class="form-control" ng-model="age.search.learning_style">
						<option value="">-- Select Learning Style --</option>
						<option ng-repeat="style in age.styles" ng-value="style.id">{! style.name!}</option>
					</select>
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'age.searchFnc($event)'
						)
					)!!}
				</div>

				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'age.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<button class="btn btn-blue btn-small content-btn" ng-click="age.setActive('add')">
			<i class="fa fa-plus-square"></i> Add Age Group
		</button>

		<div class="title-mid">
			Age Group List
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
						'ng-model' => 'age.table.size'
						, 'ng-change' => 'age.paginateBySize()'
						, 'ng-if' => "age.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive">
				<table id="tip-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Age</th>
				            <th>Total Earned Points</th>
				            <th ng-if="age.age_records.length">Action</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="ageInfo in age.age_records">
				            <td>{! ageInfo.age_group.age !}</td>
				            <td>{! ageInfo.points_earned !}</td>
				            <td ng-if="age.age_records.length">
				            	<div class="row">
				            		<div class="col-xs-6">
				            			<a href="" ng-click="age.setActive(futureed.ACTIVE_EDIT, ageInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            		<div class="col-xs-6">
				            			<a href="" ng-click="age.confirmDelete(ageInfo.id)"><span><i class="fa fa-trash"></i></span></a>
				            		</div>
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!age.age_records.length && !age.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="age.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="age.age_records.length">
				<pagination 
					total-items="age.table.total_items" 
					ng-model="age.table.page"
					max-size="3"
					items-per-page="age.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="age.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div id="delete_age_group_modal" ng-show="age.delete.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <div class="modal-header">
			        Delete Age Group
			    </div>
			    <div class="modal-body">
			        Are you sure you want to delete this Age Group?
			    </div>
			    <div class="modal-footer">
			    	<div class="btncon col-md-8 col-md-offset-4 pull-left">
			            {!! Form::button('Yes'
			                , array(
			                    'class' => 'btn btn-blue btn-medium'
			                    , 'ng-click' => 'age.deleteAgeGroup()'
			                    , 'data-dismiss' => 'modal'
			                )
			            ) !!}
			            {!! Form::button('Hidden'
			        		, array(
			        			'class' => 'hidden'
			        			, 'id' => 'age-list-btn'
			        			, 'ng-click' => "module.setActive('view', module.details.id); age.setActive('','',1)"
			        		)
			        	) !!}

			            {!! Form::button('No'
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