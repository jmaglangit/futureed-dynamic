<div ng-if="age.active_list" class="col-xs-12" id="age-group">
<div class="clearfix"></div>
<button class="btn btn-blue btn-small margin-0-30" ng-click="age.setActive('add')">
	<i class="fa fa-plus-square"></i> Add Age Group
</button>
<div class="module-container">
	<div class="title-mid">
		Age Group List
	</div>

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
				'ng-model' => 'module.table.size'
				, 'ng-change' => 'module.paginateBySize()'
				, 'ng-if' => "module.age_records.length"
				, 'class' => 'form-control paginate-size pull-right'
			)
		) !!}
	</div>
</div>
<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table id="module-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Age</th>
			            <th>Total Earned Points</th>
			            <th ng-if="module.age_records.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="ageInfo in module.age_records">
			            <td>{! ageInfo.age_group.age !}</td>
			            <td>{! ageInfo.points_earned !}</td>
			            <td ng-if="module.age_records.length">
			            	<div class="row">
			            		<div class="col-xs-6">
			            			<a href="" ng-click="age.setActive(futureed.ACTIVE_EDIT, moduleInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-6">
			            			<a href="" ng-click="age.confirmDelete(moduleInfo.id)"><span><i class="fa fa-trash"></i></span></a>
			            		</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!module.age_records.length">
			        	<td valign="top" colspan="7">
			        		No records found
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="module.age_records.length">
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