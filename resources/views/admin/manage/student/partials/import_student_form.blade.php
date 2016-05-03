<div ng-if="student.active_import">
    <div class="content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.admin_student_management') !!}</span>
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
                    <div class="btn btn-blue" ngf-select ngf-change="student.importFile($files)" accept="text/csv">
                        {!! trans('messages.upload_csv_file') !!}
                    </div>
                </div>
                <br>

                <div class="col-xs-5">
                    <a href="/downloads/student_template.xls">{!! trans('messages.download_template') !!}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 import-container" ng-If="student.report_status">
        <div class="title-mid">
            {!! trans('messages.status') !!}
        </div>
        {{--Big container of report--}}
        <div>
            <hr>
            <p>{!! trans('messages.admin_registered_users') !!} : {! student.upload_records.inserted_count !}</p>

            <p>{!! trans('messages.admin_not_registered') !!} : {! student.upload_records.fail_count !}</p>

            <div ng-if="student.fail_count">
                <hr>
                <h5>{!! trans('messages.admin_records_not_inserted') !!}</h5>
                <hr>
                <div ng-repeat="student in student.upload_records.failed_records">
                    <div class="imprt-err">
                        <hr>
                        <div class="imprt-err-hdr">{!! trans('messages.admin_error') !!} : </div>
                        <div class="imprt-err-msgs" ng-repeat="error in student.errors">
                            <div>- {! error.message !}</div>
                        </div>
                        <hr>
                    </div>
                    <div>{!! trans('messages.username') !!} : {! student.username !}</div>

                    <div>{!! trans('messages.email') !!} : {! student.email !}</div>

                    <div>{!! trans('messages.name') !!} : {! student.first_name  +' ' + student.last_name !}</div>

                    <div>{!! trans('messages.birthday') !!} : {! student.birth_date !}</div>

                    <div>{!! trans('messages.gender') !!} : {! student.gender !}</div>

                    <div>{!! trans('messages.type') !!} : {! student.user_type !}</div>

                    <div>{!! trans('messages.school') !!} : {! student.school !}</div>

                    <div>{!! trans('messages.grade_code') !!} : {! student.grade_code !}</div>

                    <div>{!! trans('messages.country') !!} : {! student.country !}</div>

                    <div>{!! trans('messages.state') !!} : {! student.state !}</idv>

                    <div>{!! trans('messages.city') !!} : {! student.city !}</div>
                    <hr>
                </div>
            </div>

        </div>
    </div>
</div>