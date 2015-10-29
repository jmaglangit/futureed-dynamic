<div ng-if="logs.active_errors_log">
	<div class="col-xs-12 success-container" ng-if="logs.errors || logs.success">
		<div class="alert alert-error" ng-if="logs.errors">
			<p ng-repeat="error in logs.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="logs.success">
            <p>{! logs.success !}</p>
        </div>
    </div>
	 
	<div class="table-container">
		<div class="list-container" ng-cloak>
			<div class="col-xs-12 title-mid">
				Logs
			</div>
	
			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Log Files</th>
			            <th>Download</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="record in logs.records">
			            <td>{! record.name !}</td>
			            <td>
	            			<a target="_self" href="{! record.path !}" 
	            				tooltip="{! record.name !}"
	            				tooltip-placement="top"
	            				tooltip-trigger="mouseenter"
	            				download="{! record.name !}">
	            				<span><i class="fa fa-download"></i></span>
	            			</a>
			            </td>

			        </tr>
			        <tr class="odd" ng-if="!logs.records.length">
			        	<td valign="top" colspan="10">
			        		No records found
			        	</td>
			        </tr>
		        </tbody>
			</table>
		</div>
	</div>
</div>