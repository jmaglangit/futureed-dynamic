<div class="row">

    <div class="col-xs-12 class-container">
        <ul class="nav nav-pills module-pills" role="tablist" ng-init="class.listClass()">
            <li role="presentation" class="module-tabs" ng-class="{ 'active' : aClass.class_id == class.current_class }">
                <a href="#">Module</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="list-container" ng-cloak>
                    <div class="clearfix"></div>

                    {{--<div class="module-list" ng-if="!class.records.length && !class.table.loading">--}}
                        {{--<div class="no-module-label">--}}
                            {{--<p>No modules found.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="module-list">
                        <div class="no-module-label">
                            <p>Loading...</p>
                        </div>
                    </div>

                    <div class="module-list" ng-if="class.records.length">
                        <div class="module-item" ng-repeat="record in class.records">
                            <div class="module-image-holder">
                                <img ng-if="record.module_status != 'Completed' && user.points >= record.points_to_unlock" class="module-icon"
                                     ng-src="{! record.icon_image == futureed.NONE && '/images/icons/default-module-icon.png' || record.icon_image !}"
                                     ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">

                                <img ng-if="record.module_status !== 'Completed' && user.points < record.points_to_unlock" class="locked-module-icon"
                                     ng-src="/images/icons/icon-lock.png" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">

                                <img ng-if="record.module_status == 'Completed'" class="locked-module-icon"
                                     ng-src="{! record.icon_image == futureed.NONE && '/images/icons/default-module-icon.png' || record.icon_image !}" tooltip-class="module-tooltip" tooltip-placement="bottom" tooltip="{! record.name !}">
                            </div>

                            <p class="module-name">{! record.name !}</p>

                            <button ng-if="record.module_status == 'On Going' && user.points >= record.points_to_unlock"
                                    ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
                                    type="button" class="btn btn-blue module-btn"><i class="fa fa-play-circle"></i> Resume </button>

                            <button ng-if="!record.module_status && user.points >= record.points_to_unlock" ng-click="class.redirect('{!! route('student.class.module.index') !!}', record)"
                                    type="button" class="btn btn-blue module-btn"><i class="fa fa-pencil"></i> Begin </button>

                            <button ng-if="user.points < record.points_to_unlock"
                                    type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> Locked</button>

                            <button ng-if="record.module_status == 'Completed'"
                                    type="button" class="btn btn-blue module-btn" ng-disabled="true"><i class="fa fa-lock"></i> Completed</button>

                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                     ng-class="{
										'progress-bar-success' : record.progress > 75,
										'progress-bar-info' : record.progress > 50 && record.progress <= 75 ,
										'progress-bar-warning' : record.progress > 25 && record.progress <= 50 ,
										'progress-bar-danger' : record.progress <= 25,

									}"
                                     ng-style="{ 'width' : record.progress+'%' }">
                                </div>
                            </div>
                            <span class="module-progress">{! record.progress !}%</span>
                        </div>
                    </div>

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
    </div>
</div>