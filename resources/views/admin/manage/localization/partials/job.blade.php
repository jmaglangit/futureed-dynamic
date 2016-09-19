<div>
    <div class="col-xs-12 search-container" ng-init="localization.jobList()">
        <div class="title-mid">{!! trans('messages.job_on_queue') !!}</div>
        <div class="form-group">
            <div>
                <div class="btn btn-blue btn-small pull-right" ng-click="localization.jobList()"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh Queue</div>
                <div class="panel panel-default col-xs-12">
                    <div class="panel-body">
                        <p ng-if="localization.job_list.length > futureed.TRUE" ng-repeat="job in localization.job_list">{!  job.message !}</p>
                        <p ng-if="localization.job_list.length == futureed.FALSE">{!! trans('messages.job_on_queue_none') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


