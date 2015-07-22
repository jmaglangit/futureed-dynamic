<div class="col-xs-12 margin-top-15" ng-if="mod.active_help_list">
	<div class="alert alert-error" ng-if="mod.errors">
        <p ng-repeat="error in mod.errors track by $index" > 
            {! error !}
        </p>
    </div>
    <div class="col-xs-12" ng-init="mod.setCurrentActive()">
    	<ul class="nav nav-pills col-xs-8">
    		<li class="active">
    			<a class="pill-grey" href="#tab1" data-toggle="tab">From your Classmates [2]</a>
    		</li>
    		<li>
    			<a class="pill-grey" href="#tab2" data-toggle="tab">From you [2]</a>
    		</li>
    	</ul>
    	<ul class="nav nav-pills col-xs-4 pull-right nav-gold">
    		<li class="active">
    			<a class="pill-gold" href="#tab3" data-toggle="tab" ng-click="mod.setCurrentActive()">Current</a>
    		</li>
    		<li>
    			<a class="pill-gold" href="#tab4" data-toggle="tab">All</a>
    		</li>
    	</ul>
    	<div class="tab-content">
    		<div class="tab-pane" id="tab1">
		    	1
		    </div>
		    <div class="tab-pane" id="tab2">
		    	2
		    </div>
		    <div class="tab-pane active" id="tab3">
		    	<div template-directive template-url="{!! route('student.class.module.partials.current_help') !!}"></div>
		    </div>
		    <div class="tab-pane" id="tab4">
		    	4
		    </div>
    	</div>
    </div>
</div>