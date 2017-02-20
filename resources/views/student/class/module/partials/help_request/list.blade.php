<div class="col-xs-12 margin-top-15" ng-if="help.active_list">
    <div class="alert alert-error" ng-if="help.errors">
        <p ng-repeat="error in help.errors track by $index" > 
            {! error !}
        </p>
    </div>
    <div class="alert alert-success" ng-if="help.success">
    	<p>{! help.success !}</p>
    </div>
    
    <div class="col-xs-12">
    	<ul class="nav nav-pills col-xs-12">
    		<li ng-class="{ 'active' : help.active_classmate }">
    			<a class="pill-grey" href="javascript:void(0);" 
                    data-toggle="tab" ng-click="help.setHelpTabActive(futureed.CLASSMATE)">{!! trans('messages.from_your_classmates') !!}</a>
    		</li>
    		<li ng-class="{ 'active' : help.active_own }">
    			<a class="pill-grey" href="javascript:void(0);" 
                    data-toggle="tab" ng-click="help.setHelpTabActive(futureed.OWN)">{!! trans('messages.from_you') !!}</a>
    		</li>
    		<li class="pull-right" ng-class="{ 'active' : help.active_all }">
    			<a class="pill-gold" href="javascript:void(0);" 
                    data-toggle="tab" ng-click="help.setHelpTabActive(futureed.ALL)">{!! trans('messages.all') !!}</a>
    		</li>
    		<li class="pull-right" ng-class="{ 'active' : help.active_current }">
    			<a class="pill-gold" href="javascript:void(0);" 
                    data-toggle="tab" ng-click="help.setHelpTabActive(futureed.CURRENT)">{!! trans('messages.current') !!}</a>
    		</li>
    	</ul>

    	<div class="tab-content">
		    <div class="tab-pane active">
                <div id="help_request_list" class="help-container">
                    <div class="content-box" ng-if="!help.records.length">
                        <div class="row content-row">
                            <center><p>{!! trans('messages.no_help_request_found') !!}</p></center>
                        </div>
                    </div>

                    <div class="content-box" ng-repeat="record in help.records">
                        <div class="row content-row">
                            <div class="col-xs-6">
                                <span class="content-bar-title" ng-click="help.setModuleActive(futureed.ACTIVE_VIEW, record.id)">
                                    {! record.title !}
                                </span>
                            </div>
                        </div>
                        <div class="row content-row">
                            <div class="col-xs-6">
                                <span><i class="fa fa-user"></i> {! record.student.first_name !} {! record.student.last_name !}</span>
                            </div>
                        </div>
                        <div class="row content-row">
                            <div class="col-xs-6">
                                <span><i class="fa fa-tag"></i> {! record.link_type !} </span>
                            </div>
                            <div class="col-xs-6">
                                <span><i class="fa fa-calendar-o"></i> {! record.created_at !}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-8" ng-if="mod.show_btn">
                        <button class="btn btn-green" ng-click="mod.tipList('', futureed.CURRENT, 1)">{!! trans('messages.view_more') !!}</button>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>