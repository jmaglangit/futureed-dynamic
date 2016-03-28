<div ng-if="client.active_import">
    <div class="content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.admin_client_management') !!}</span>
        </div>
    </div>

    <div class="col-xs-12 success-container" ng-if="client.errors || client.success">
        <div class="alert alert-error" ng-if="client.errors">
            <p ng-repeat="error in client.errors track by $index">
                {! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="client.success">
            <p>{! client.success !}</p>
        </div>
    </div>

    <div class="col-xs-12 import-container">
        <div class="title-mid">
            {!! trans('messages.import') !!}
        </div>

        {{--Import Files--}}
        <div class="form-import">
            {!! Form::open(
				array(
					'id' => 'search_form'
					, 'class' => 'form-horizontal'
				)
			) !!}
            <div class="form-group">
                {{--Upload file--}}
                <div class="col-xs-6">
                    <div class="btn btn-blue" ngf-select ngf-change="client.importFile($files)" accept="text/csv">
                        {!! trans('messages.upload_csv_file') !!}
                    </div>
                </div>
                <br>

                <div class="col-xs-5">
                    <a href="/downloads/teacher_template.xls">{!! trans('messages.download_template') !!}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 import-container" ng-If="client.report_status">
        <div class="title-mid">
            {!! trans('messages.status') !!}
        </div>
        {{--Big container of report--}}
        <div>
            <hr>
            <p>{!! trans('messages.admin_registered_users') !!} : {! client.upload_records.inserted_count !}</p>

            <p>{!! trans('messages.admin_not_registered') !!} : {! client.upload_records.fail_count !}</p>

            <div ng-if="client.fail_count">
                <hr>
                <h5>{!! trans('messages.admin_records_not_inserted') !!}</h5>
                <hr>
                <div ng-repeat="client in client.upload_records.failed_records">
                    <div class="imprt-err">
                        <hr>
                        <div class="imprt-err-hdr">{!! trans('messages.admin_error', 2) !!}:</div>
                        <div class="imprt-err-msgs" ng-repeat="error in client.errors">
                            <div>- {! error.message !}</div>
                        </div>
                        <hr>
                    </div>
                    <div>{!! trans('messages.username') !!} : {! client.username !}</div>

                    <div>{!! trans('messages.email') !!} : {! client.email !}</div>

                    <div>{!! trans('messages.name') !!} : {! client.first_name + ' ' + client.last_name !}</div>

                    <div>{!! trans('messages.birthday') !!} : {! client.birth_date !}</div>

                    <div>{!! trans('messages.gender') !!} : {! client.gender !}</div>

                    <div>{!! trans('messages.type') !!} : {! client.user_type !}</div>

                    <div>{!! trans('messages.school') !!} : {! client.school !}</div>

                    <div>{!! trans('messages.grade_code') !!} : {! client.grade_code !}</div>

                    <div>{!! trans('messages.country') !!} : {! client.country !}</div>

                    <div>{!! trans('messages.state') !!} : {! client.state !}</div>

                    <div>{!! trans('messages.city') !!} : {! client.city !}</div>
                    <hr>
                </div>
            </div>

        </div>
    </div>
</div>