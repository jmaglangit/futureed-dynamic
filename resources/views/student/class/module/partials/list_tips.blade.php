<div class="col-xs-12 margin-top-15" ng-if="mod.active_tip_list">
	<div class="alert alert-error" ng-if="mod.errors">
        <p ng-repeat="error in mod.errors track by $index" > 
            {! error !}
        </p>
    </div>
    <div class="alert alert-success" ng-if="mod.success">
    	<p>{! mod.success !}</p>
    </div>
    <div class="col-xs-12" ng-init="mod.setTabActive(futureed.CURRENT)">
    	<ul class="nav nav-pills col-xs-12">
    		<li class="active">
    			<a class="pill-grey" href="#tab1" data-toggle="tab" ng-click="mod.setTabActive(futureed.CURRENT)">Current</a>
    		</li>
    		<li>
    			<a class="pill-grey" href="#tab2" data-toggle="tab" ng-click="mod.setTabActive(futureed.ALL)">All</a>
    		</li>
    	</ul>
    	<div class="tab-content">
    		<div class="tab-pane active" id="tab1" ng-if="mod.current_view == futureed.CURRENT">
		    	<div ng-init="mod.setCurrentActiveTip()">
		    		<div template-directive template-url="{!! route('student.class.module.partials.list_current_tips') !!}"></div>
		    	</div>
		    </div>
		    <div class="tab-pane" id="tab2" ng-if="mod.current_view == futureed.ALL">
		    	<div ng-init="mod.setAllActiveTip()">
		    		<div template-directive template-url="{!! route('student.class.module.partials.list_all_tips') !!}"></div>
		    	</div>
		    </div>
    	</div>
    </div>
</div>