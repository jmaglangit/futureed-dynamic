<div ng-if="client.active_import">
    <div class="content-title">
        <div class="title-main-content">
            <span>Client Management</span>
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
                    <div class="btn btn-blue" ngf-select ngf-change="client.importFile($files)" accept="text/csv">
                        Upload CSV file
                    </div>
                </div>
                <br>

                <div class="col-xs-5">
                    <a href="/downloads/teacher_template.xls">Download Template</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 import-container" ng-If="client.report_status">
        <div class="title-mid">
            Status
        </div>
        {{--Big container of report--}}
        <div>
            <hr>
            <p>Registered Users : {! client.upload_records.inserted_count !}</p>

            <p>Not Registered : {! client.upload_records.fail_count !}</p>

            <div ng-if="client.fail_count">
                <hr>
                <h5>Records Not Inserted</h5>
                <hr>
                <div ng-repeat="client in client.upload_records.failed_records">
                    <p>Username : {! client.errors.username !}</p>

                    <p>Email : {! client.errors.email !}</p>

                    <p>Name : {! client.errors.first_name !}</p>

                    <p>Birthdate : {! client.errors.birth_date !}</p>

                    <p>Gender : {! client.errors.gender !}</p>

                    <p>Type : {! client.errors.user_type !}</p>

                    <p>School : {! client.errors.school !}</p>

                    <p>Grade Code : {! client.errors.grade_code !}</p>

                    <p>County : {! client.errors.country !}</p>

                    <p>State : {! client.errors.state !}</p>

                    <p>City : {! client.errors.city !}</p>
                    <hr>
                </div>
            </div>

        </div>
    </div>
</div>