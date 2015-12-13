<div ng-if="student.active_import">
    <div class="content-title">
        <div class="title-main-content">
            <span>Student Management</span>
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
            Import
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
                        Upload CSV file
                    </div>
                </div>
                <br>

                <div class="col-xs-5">
                    <a href="/downloads/student_template.xls">Download Template</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 import-container" ng-If="student.report_status">
        <div class="title-mid">
            Status
        </div>
        {{--Big container of report--}}
        <div>
            <hr>
            <p>Registered Users : {! student.upload_records.inserted_count !}</p>

            <p>Not Registered : {! student.upload_records.fail_count !}</p>

            <div ng-if="student.fail_count">
                <hr>
                <h5>Records Not Inserted</h5>
                <hr>
                <div ng-repeat="student in student.upload_records.failed_records">
                    <div class="imprt-err">
                        <hr>
                        <div class="imprt-err-hdr">Error(s) : </div>
                        <div class="imprt-err-msgs" ng-repeat="error in student.errors">
                            <div>- {! error.message !}</div>
                        </div>
                        <hr>
                    </div>
                    <div>Username : {! student.username !}</div>

                    <div>Email : {! student.email !}</div>

                    <div>Name : {! student.first_name  +' ' + student.last_name !}</div>

                    <div>Birthdate : {! student.birth_date !}</div>

                    <div>Gender : {! student.gender !}</div>

                    <div>Type : {! student.user_type !}</div>

                    <div>School : {! student.school !}</div>

                    <div>Grade Code : {! student.grade_code !}</div>

                    <div>County : {! student.country !}</div>

                    <idv>State : {! student.state !}</idv>

                    <div>City : {! student.city !}</div>
                    <hr>
                </div>
            </div>

        </div>
    </div>
</div>