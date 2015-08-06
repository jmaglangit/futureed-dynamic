<div class="col-xs-12 margin-top-15" ng-if="mod.active_help_list">
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
    		<li>
    			<a class="pill-grey" href="#tab1" data-toggle="tab" ng-click="mod.setTabActive(futureed.CLASSMATE)">From your Classmates [2]</a>
    		</li>
    		<li>
    			<a class="pill-grey" href="#tab2" data-toggle="tab" ng-click="mod.setTabActive(futureed.OWN)">From you</a>
    		</li>
    		<li class="pull-right">
    			<a class="pill-gold" href="#tab4" data-toggle="tab" ng-click="mod.setTabActive(futureed.ALL)">All</a>
    		</li>
    		<li class="active nav-gold pull-right">
    			<a class="pill-gold" href="#tab3" data-toggle="tab" ng-click="mod.setTabActive(futureed.CURRENT)">Current</a>
    		</li>
    	</ul>
    	<div class="tab-content">
    		<div class="tab-pane" id="tab1">
		    	1
		    </div>
		    <div class="tab-pane" id="tab2" ng-if="mod.current_view == futureed.OWN">
		    	<div ng-init="mod.setOwnActive()">
		    		<div template-directive template-url="{!! route('student.class.module.partials.list_your_help') !!}"></div>
		    		<div template-directive template-url="{!! route('student.class.module.partials.view_your_help') !!}"></div>
		    	</div>
		    </div>
		    <div class="tab-pane active" id="tab3" ng-if="mod.current_view == futureed.CURRENT">
		    	<div ng-init="mod.setCurrentActive()">
		    		<div template-directive template-url="{!! route('student.class.module.partials.current_help') !!}"></div>
		    		<div template-directive template-url="{!! route('student.class.module.partials.current_view_help') !!}"></div>
		    	</div>
		    </div>
		    <div class="tab-pane" id="tab4">
		    	4
		    </div>
    	</div>
    </div>
</div>