angular.module('futureed.controllers')
    .controller('ManagePrincipalContentController', ManagePrincipalContentController);

ManagePrincipalContentController.$inject = ['$scope', '$filter', 'ManagePrincipalContentService', 'clientProfileApiService', 'apiService'];

function ManagePrincipalContentController($scope, $filter, ManagePrincipalContentService, clientProfileApiService, apiService) {
    var self = this;


    //set active controller
    self.setActive = function (active) {


        self.active_report = Constants.FALSE;
        self.active_school = Constants.FALSE;
        self.active_school_teacher = Constants.FALSE;
        self.export = Constants.FALSE;

        //self.active_report = Constants.TRUE;

        switch (active) {
            case Constants.ACTIVE_SCHOOL_TEACHER:
                self.active_school = Constants.FALSE;
                self.active_report = Constants.TRUE;
                self.active_school_teacher = Constants.TRUE;
                break;

            case Constants.ACTIVE_SCHOOL:
                self.active_school_teacher = Constants.FALSE;
                self.active_report = Constants.TRUE;
                self.active_school = Constants.TRUE;
                break;

            default:
                self.getPrincipal();
                break;
        }
    }

    //get client principal school code
    self.getPrincipal = function () {
        self.errors = Constants.FALSE;
        self.principal = {};

        $scope.ui_block();
        clientProfileApiService.getClientDetails($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.principal = response.data;

                    self.checkReport();
                    self.teacherReport();
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }


    //check if client has existing report.
    self.checkReport = function () {
        self.errors = Constants.FALSE;
        //self.school_code = school_code;
        self.report = {};

        //Report variables
        self.report_active_skill = Constants.TRUE;
        self.report_active_class = Constants.TRUE;
        self.report_active_student = Constants.TRUE;

        $scope.ui_block();
        ManagePrincipalContentService.schoolReport(self.principal.school_code).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.report = response.data;


                    //if skill has record
                    if (self.report.rows.skills_watch.highest_skill === null
                        || self.report.rows.skills_watch.lowest_skill === null) {
                        self.report_active_skill = Constants.FALSE;
                    }

                    //if class has record
                    if (self.report.rows.class_watch.highest_class === null
                        && self.report.rows.class_watch.lowest_class === null) {
                        self.report_active_class = Constants.FALSE;
                    }

                    //if student has record
                    if (self.report.rows.student_watch === null) {
                        self.report_active_student = Constants.FALSE;
                    }

                    //Check if report has data.
                    if (self.report.rows.skills_watch.highest_skill === null
                        || self.report.rows.skills_watch.lowest_skill === null
                        || self.report.rows.class_watch.highest_class === null
                        || self.report.rows.class_watch.lowest_class === null
                        || self.report.rows.student_watch
                        || self.report.rows.highest_score.id == 0
                        || self.report.rows.lowest_score.id == 0) {

                        self.active_report = Constants.TRUE;
                        self.active_school = Constants.TRUE;
                    }
                }
            }
            $scope.ui_unblock();


        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });


    }

    //get report details
    self.teacherReport = function () {
        self.errors = Constants.FALSE;
        self.teacher_report = {};

        $scope.ui_block();
        ManagePrincipalContentService.schoolTeacherReport(self.principal.school_code).success(function(response){
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.teacher_report = response.data;
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //export school report
    self.exportSchoolReport = function(file_type){
        self.errors = $scope.internalError();

        //$scope.ui_block();
        //ManagePrincipalContentService.schoolReportDownload(self.principal.school_code, file_type).success(function(response){
        //
        //    $scope.ui_unblock();
        //}).error(function (response) {
        //    self.errors = $scope.internalError();
        //    $scope.ui_unblock();
        //});
    }


}