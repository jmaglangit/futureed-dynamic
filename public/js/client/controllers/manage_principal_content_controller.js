angular.module('futureed.controllers')
    .controller('ManagePrincipalContentController', ManagePrincipalContentController);

ManagePrincipalContentController.$inject = ['$scope', '$filter', 'ManagePrincipalContentService', 'clientProfileApiService', 'apiService'];

function ManagePrincipalContentController($scope, $filter, ManagePrincipalContentService, clientProfileApiService, apiService) {
    var self = this;

    // collection of options used in the drop down list
    self.subjects = {};
    self.grades = {};

    // selected values from drop down list
    self.selected = {};
    self.selected.subject_id = -1;
    self.selected.grade_id = -1;

    self.initSelection = function () {
        self.selected.subject_id = -1;
        self.selected.grade_id = -1;
    }

    //set active controller
    self.setActive = function (active) {

        self.active_report_teacher = Constants.FALSE;
        self.active_school = Constants.FALSE;
        self.active_school_teacher = Constants.FALSE;
        self.active_school_teacher_progress = Constants.FALSE;
        self.active_school_teacher_scores = Constants.FALSE;
        self.export = Constants.FALSE;
        self.active_purchase = Constants.FALSE;

        switch (active) {
            case Constants.ACTIVE_SCHOOL_TEACHER:
                self.active_report_teacher = Constants.TRUE;
                self.active_school_teacher = Constants.TRUE;
                self.export = Constants.TRUE;
                break;

            case Constants.ACTIVE_SCHOOL:
                self.active_report_teacher = Constants.TRUE;
                self.active_school = Constants.TRUE;
                self.export = Constants.TRUE;
                break;

            case Constants.ACTIVE_SCHOOL_TEACHER_PROGRESS:
                self.active_report_teacher = Constants.TRUE;
                self.active_school_teacher_progress = Constants.TRUE;
                self.export = Constants.TRUE;
                break;

            case Constants.ACTIVE_SCHOOL_TEACHER_SCORES:
                self.active_report_teacher = Constants.TRUE;
                self.active_school_teacher_scores = Constants.TRUE;
                self.export = Constants.TRUE;
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

                    console.dir(self.principal);

                    self.getGrades();
                    self.getSubjects();

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

                    self.active_report_teacher = Constants.TRUE;
                    self.active_school = Constants.TRUE;
                    self.active_purchase = Constants.FALSE;

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
                    if (self.report.rows.student_watch.length == 0) {
                        self.report_active_student = Constants.FALSE;
                    }

                    //Check if report has data.
                    if (self.report.rows.skills_watch.highest_skill === null
                        && self.report.rows.skills_watch.lowest_skill === null) {

                        self.active_report_teacher = Constants.FALSE;
                        self.active_school = Constants.FALSE;
                        self.export = Constants.FALSE;
                        self.active_purchase = Constants.TRUE;
                    }
                } else {
                    self.active_purchase = Constants.TRUE;
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
        ManagePrincipalContentService.schoolTeacherReport(self.principal.school_code).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.teacher_report = response.data;

                    //check if has data
                    if (self.teacher_report.rows.length > 0) {
                        self.active_report_teacher = Constants.TRUE;
                        self.active_school = Constants.TRUE;
                        self.export = Constants.TRUE;
                        self.active_purchase = Constants.FALSE;
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
    self.teacherSubjectProgressReport = function () {
        self.errors = Constants.FALSE;
        self.teacher_subject_progress_report = {};

        if (self.isValidGrade()) {
            $scope.ui_block();
            ManagePrincipalContentService.schoolTeacherSubjectProgressReport
                (self.principal.school_code, self.selected.grade_id)
                .success(function (response) {
                if (angular.equals(response.status, Constants.STATUS_OK)) {
                    if (response.errors) {
                        self.errors = $scope.errorHandler(response.errors);
                    } else if (response.data) {
                        self.teacher_subject_progress_report = response.data;

                        //check if has data
                        if (self.teacher_subject_progress_report.rows.length > 0) {
                            self.active_report_teacher = Constants.TRUE;
                            self.active_school_teacher_progress = Constants.TRUE;
                            self.export = Constants.TRUE;
                            self.active_purchase = Constants.FALSE;
                        }
                    }
                }
                $scope.ui_unblock();
            }).error(function (response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
            self.teacher_subject_progress_table = Constants.TRUE;
        } else {
            self.teacher_subject_progress_table = Constants.FALSE;
        }
    }

    self.teacherSubjectProgressReport = function () {
        self.errors = Constants.FALSE;
        self.teacher_subject_progress_report = {};

        if (self.isValidGrade()) {
            $scope.ui_block();
            ManagePrincipalContentService.schoolTeacherSubjectProgressReport
            (self.principal.school_code, self.selected.grade_id)
                .success(function (response) {
                    if (angular.equals(response.status, Constants.STATUS_OK)) {
                        if (response.errors) {
                            self.errors = $scope.errorHandler(response.errors);
                        } else if (response.data) {
                            self.teacher_subject_progress_report = response.data;

                            //check if has data
                            if (self.teacher_subject_progress_report.rows.length > 0) {
                                self.active_report_teacher = Constants.TRUE;
                                self.active_school_teacher_progress = Constants.TRUE;
                                self.export = Constants.TRUE;
                                self.active_purchase = Constants.FALSE;
                            }
                        }
                    }
                    $scope.ui_unblock();
                }).error(function (response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
            self.teacher_subject_progress_table = Constants.TRUE;
        } else {
            self.teacher_subject_progress_table = Constants.FALSE;
        }
    }

    self.teacherSubjectScoresReport = function () {
        self.errors = Constants.FALSE;
        self.teacher_subject_scores_report = {};

        if (self.isValidGrade()) {
            $scope.ui_block();
            ManagePrincipalContentService.schoolTeacherSubjectScoresReport
            (self.principal.school_code, self.selected.grade_id)
                .success(function (response) {
                    if (angular.equals(response.status, Constants.STATUS_OK)) {
                        if (response.errors) {
                            self.errors = $scope.errorHandler(response.errors);
                        } else if (response.data) {
                            self.teacher_subject_scores_report = response.data;

                            //check if has data
                            if (self.teacher_subject_scores_report.rows.length > 0) {
                                self.active_report_teacher = Constants.TRUE;
                                self.active_school_teacher_scores = Constants.TRUE;
                                self.export = Constants.TRUE;
                                self.active_purchase = Constants.FALSE;
                            }
                        }
                    }
                    $scope.ui_unblock();
                }).error(function (response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
            self.teacher_subject_progress_table = Constants.TRUE;
        } else {
            self.teacher_subject_progress_table = Constants.FALSE;
        }
    }

    ////export school report
    self.exportReport = function (file_type) {

        if (self.active_school == Constants.TRUE) {
            //download school report
            self.schoolReportExport(file_type);

        } else if (self.active_school_teacher == Constants.TRUE) {
            //download school teacher report
            self.schoolTeacherReportExport(file_type);
        } else if (self.active_school_teacher_progress == Constants.TRUE) {
            self.schoolTeacherSubjectProgressReportExport(file_type);
        } else if (self.active_school_teacher_scores == Constants.TRUE) {
            self.schoolTeacherSubjectScoresReportExport(file_type);
        }
    }

    //download school report
    self.schoolReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        self.schoolDownload = ManagePrincipalContentService.schoolReportDownload(self.principal.school_code, file_type);
        $scope.ui_unblock();

    }

    //download school teacher report
    self.schoolTeacherReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService.schoolTeacherReportDownload(self.principal.school_code, file_type);
        $scope.ui_unblock();
    }
    
    self.schoolTeacherSubjectProgressReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService
            .schoolTeacherSubjectProgressReportDownload(
                self.principal.school_code, self.selected.grade_id, file_type);
        $scope.ui_unblock();
    }
    
    self.schoolTeacherSubjectScoresReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService
            .schoolTeacherSubjectScoresReportDownload(
                self.principal.school_code, self.selected.grade_id, file_type);
        $scope.ui_unblock();
    }

    self.getGrades = function () {
        self.errors = Constants.FALSE;
        self.subjects = {};

        $scope.ui_block();
        ManagePrincipalContentService.getGrades().success(function (response) {

            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.grades = response.data;
                    console.dir(self.grades);
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getSubjects = function () {
        self.errors = Constants.FALSE;
        self.subjects = {};

        $scope.ui_block();
        ManagePrincipalContentService.getSubjects().success(function (response) {

            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.subjects = response.data;
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.subjectColumnWidth = function (remaining) {
        return remaining / self.subjects.records.length;
    }
    
    // returns true if currently selected grade is valid
    self.isValidGrade = function () {
        var valid = false;

        for (var i = 0; i < self.grades.records.length; i++) {
            if (self.grades.records[i].id === parseInt(self.selected.grade_id)) {
                valid = true;
                break;
            }
        }

        return valid;
    }

    // returns true if currently selected subject is valid
    self.isValidSubject = function () {
        var valid = false;

        for (var i = 0; i < self.subjects.records.length; i++) {
            if (self.subjects.records[i].id === parseInt(self.selected.subject_id)) {
                valid = true;
                break;
            }
        }

        return valid;
    }

    self.hasGrades = function () {
        return self.grades.total > 0
    }

    self.hasSubjects = function () {
        return self.subjects.total > 0;
    }
    // temporary helper function for testing
    self.logObject = function () {
        //console.log(self.hasGrades());
        console.log('hewo');
    }
}