<div ng-if="student.active_reward">
	<div class="content-title">
		<div class="title-main-content">
			<span>Rewards</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="student.success">
            <p>{! student.success !}</p>
        </div>
    </div>
    <div class="table-container" ng-cloak>
		<div class="title-mid">
			Point History
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
                    'ng-model' => 'student.table.size'
                    , 'ng-change' => 'student.paginateBySize()'
                    , 'ng-if' => "student.points.length"
                    , 'class' => 'form-control paginate-size pull-right'
                )
            ) !!}
        </div>

		<table class="table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>Points</th>
		            <th>Event</th>
		            <th>Description</th>
		            <th>Date Earned</th>
		            <th ng-if="student.points.length">Actions</th>
		        </tr>
		    </thead>

	        <tbody>
	        <tr ng-repeat="point in student.points">
	            <td>{! point.points_earned !}</td>
	            <td>{! point.event.name !}</td>
	            <td>{! point.description !}</td>
	            <td>{! point.earned_at !}</td>
	            <td ng-if="student.points.length">
	            	<div class="row">
	            		<div class="col-xs-12">
    						<a href="" ng-click="student.setActive('edit_reward', point.id, 'points')"><span><i class="fa fa-pencil"></i></span></a>
    					</div>
	            	</div>
	            </td>
	        </tr>
	        <tr class="odd" ng-if="!student.points.length && !student.table.loading">
	        	<td valign="top" colspan="7">
	        		No records found
	        	</td>
	        </tr>
	        <tr class="odd" ng-if="student.table.loading">
	        	<td valign="top" colspan="7">
	        		Loading...
	        	</td>
	        </tr>
	        </tbody>
		</table>

		<div class="pull-right" ng-if="student.points.length">
			<pagination 
				total-items="student.table.total_items" 
				ng-model="student.table.page"
				max-size="student.table.paging_size"
				items-per-page="student.table.size" 
				previous-text = "&lt;"
				next-text="&gt;"
				class="pagination" 
				boundary-links="true"
				ng-change="student.paginateByPage()">
			</pagination>
		</div>
	</div>
	<div class="table-container col-xs-12" ng-cloak>
		<div class="title-mid">
			Badges
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
                    'ng-model' => 'student.table.size'
                    , 'ng-change' => 'student.paginateBySize()'
                    , 'ng-if' => "student.badges.length"
                    , 'class' => 'form-control paginate-size pull-right'
                )
            ) !!}
        </div>

		<table class="table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>Badge name</th>
		            <th>Date Earned</th>
		            <th ng-if="student.badges.length">Actions</th>
		        </tr>
		    </thead>

	        <tbody>
	        <tr ng-repeat="badge in student.badges">
	            <td>{! badge.badges.name !}</td>
	            <td>{! badge.created_at !}</td>
	            <td ng-if="student.badges.length">
	            	<div class="row">
	            		<div class="col-xs-6">
    						<a href="" ng-click="student.setActive('edit_reward', badge.id, 'badge')"><span><i class="fa fa-pencil"></i></span></a>
    					</div>
    					<div class="col-xs-6">
    						<a href="" ng-click="student.confirmBadgeDelete(badge.id)"><span><i class="fa fa-trash"></i></span></a>
    					</div>
	            	</div>
	            </td>
	        </tr>
	        <tr class="odd" ng-if="!student.badges.length && !student.table.loading">
	        	<td valign="top" colspan="7">
	        		No records found
	        	</td>
	        </tr>
	        <tr class="odd" ng-if="student.table.loading">
	        	<td valign="top" colspan="7">
	        		Loading...
	        	</td>
	        </tr>
	        </tbody>
		</table>

		<div class="pull-right" ng-if="student.badges.length">
			<pagination 
				total-items="student.table.total_items" 
				ng-model="student.table.page"
				max-size="student.table.paging_size"
				items-per-page="student.table.size" 
				previous-text = "&lt;"
				next-text="&gt;"
				class="pagination" 
				boundary-links="true"
				ng-change="student.paginateByPage()">
			</pagination>
		</div>
	</div>
	<div class="col-xs-12 btn-container">
		{!! Form::button('Back'
    		, array(
    			'class' => 'btn btn-gold btn-small pull-right'
    			, 'ng-click' => "student.setActive('view', student.record.id)"
    		)
    	) !!}
	</div>
</div>