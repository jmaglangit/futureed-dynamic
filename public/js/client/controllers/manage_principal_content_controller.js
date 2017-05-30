angular.module('futureed.controllers')
    .controller('ManagePrincipalContentController', ManagePrincipalContentController);

ManagePrincipalContentController.$inject = ['$scope', '$filter', 'ManagePrincipalContentService', 'clientProfileApiService', 'apiService'];

function ManagePrincipalContentController($scope, $filter, ManagePrincipalContentService, clientProfileApiService, apiService) {
    var self = this;

    // collection of options used in the drop down list
    self.subjects = {};
    self.grades = {};
    self.teachers = {};

    // selected values from drop down list
    self.selected = {};

    self.selected.teacher_progress = {};
    self.selected.teacher_progress.grade_id = "";

    self.selected.teacher_scores = {};
    self.selected.teacher_scores.grade_id = "";

    self.selected.student_progress = {};
    self.selected.student_progress.subject_id = "";
    self.selected.student_progress.grade_id = "";
    self.selected.student_progress.teacher_id = "";

    self.selected.student_scores = {};
    self.selected.student_scores.subject_id = "";
    self.selected.student_scores.grade_id = "";
    self.selected.student_scores.teacher_id = "";

    self.number_of_pages = {};
    self.number_of_pages.student_progress = {};
    self.number_of_pages.student_scores = {};

    self.current_page = {};
    self.current_page.student_progress = {};
    self.current_page.student_scores = {};

    self.number_of_pages = {};
    self.number_of_pages.student_progress = {};
    self.number_of_pages.student_scores = {};

    //set active controller
    self.setActive = function (active) {

        self.active_report_teacher = Constants.FALSE;
        self.active_school = Constants.FALSE;
        self.active_school_teacher = Constants.FALSE;
        self.active_school_teacher_progress = Constants.FALSE;
        self.active_school_teacher_scores = Constants.FALSE;
        self.active_school_student_progress = Constants.FALSE;
        self.active_school_student_scores = Constants.FALSE;
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

            case Constants.ACTIVE_SCHOOL_STUDENT_PROGRESS:
                self.active_report_teacher = Constants.TRUE;
                self.active_school_student_progress = Constants.TRUE;
                self.export = Constants.TRUE;
                break;

            case Constants.ACTIVE_SCHOOL_STUDENT_SCORES:
                self.active_report_teacher = Constants.TRUE;
                self.active_school_student_scores = Constants.TRUE;
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

                    self.getGrades();
                    self.getSubjects();
                    self.getTeachers();

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

        if (self.selected.teacher_progress.grade_id) {
            $scope.ui_block();
            ManagePrincipalContentService.schoolTeacherSubjectProgressReport
            (self.principal.school_code, self.selected.teacher_progress.grade_id)
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

        if (self.selected.teacher_scores.grade_id) {
            $scope.ui_block();
            ManagePrincipalContentService.schoolTeacherSubjectScoresReport
            (self.principal.school_code, self.selected.teacher_scores.grade_id)
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
        } else {
        }
    }

    self.studentSubjectProgressReport = function () {
        self.errors = Constants.FALSE;
        self.student_subject_progress_report = {};

        if (self.selected.student_progress.subject_id
            && self.selected.student_progress.grade_id
            && self.selected.student_progress.teacher_id) {

            $scope.ui_block();
            ManagePrincipalContentService.schoolStudentSubjectProgressReport
            (self.principal.school_code, self.selected.student_progress.teacher_id,
                self.selected.student_progress.subject_id, self.selected.student_progress.grade_id)
                .success(function (response) {
                    if (angular.equals(response.status, Constants.STATUS_OK)) {
                        if (response.errors) {
                            self.errors = $scope.errorHandler(response.errors);
                        } else if (response.data) {
                            self.student_subject_progress_report = response.data;

                            self.number_of_pages.student_progress = Object.keys(self.student_subject_progress_report.column_header).length;

                            self.current_page.student_progress = 1;

                            //check if has data
                            if (self.student_subject_progress_report.rows.length > 0) {
                                self.active_report_teacher = Constants.TRUE;
                                self.active_school_student_progress = Constants.TRUE;
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
        } else {
        }
    }

    self.studentSubjectScoresReport = function () {
        self.errors = Constants.FALSE;
        self.student_subject_scores_report = {};

        if (self.selected.student_scores.subject_id
            && self.selected.student_scores.grade_id
            && self.selected.student_scores.teacher_id) {

            $scope.ui_block();
            ManagePrincipalContentService.schoolStudentSubjectScoresReport
            (self.principal.school_code, self.selected.student_scores.teacher_id,
                self.selected.student_scores.subject_id, self.selected.student_scores.grade_id)
                .success(function (response) {
                    if (angular.equals(response.status, Constants.STATUS_OK)) {
                        if (response.errors) {
                            self.errors = $scope.errorHandler(response.errors);
                        } else if (response.data) {
                            self.student_subject_scores_report = response.data;

                            self.number_of_pages.student_scores = Object.keys(self.student_subject_scores_report.column_header).length;

                            self.current_page.student_scores = 1;

                            //check if has data
                            if (self.student_subject_scores_report.rows.length > 0) {
                                self.active_report_teacher = Constants.TRUE;
                                self.active_school_student_scores = Constants.TRUE;
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
        } else {
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
        } else if (self.active_school_student_progress == Constants.TRUE) {
            self.schoolStudentSubjectProgressReportExport(file_type);
        } else if (self.active_school_student_scores == Constants.TRUE) {
            self.schoolStudentSubjectScoresReportExport(file_type);
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
                self.principal.school_code, self.selected.teacher_progress.grade_id, file_type);
        $scope.ui_unblock();
    }

    self.schoolTeacherSubjectScoresReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService
            .schoolTeacherSubjectScoresReportDownload(
                self.principal.school_code, self.selected.teacher_scores.grade_id, file_type);
        $scope.ui_unblock();
    }

    self.schoolStudentSubjectProgressReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService
            .schoolStudentSubjectProgressReportDownload(
                self.principal.school_code, self.selected.student_progress.teacher_id,
                self.selected.student_progress.subject_id, self.selected.student_progress.grade_id, file_type);
        $scope.ui_unblock();
    }

    self.schoolStudentSubjectScoresReportExport = function (file_type) {
        self.errors = Constants.FALSE;

        $scope.ui_block;
        self.schoolDownload = ManagePrincipalContentService
            .schoolStudentSubjectScoresReportDownload(
                self.principal.school_code, self.selected.student_scores.teacher_id,
                self.selected.student_scores.subject_id, self.selected.student_scores.grade_id, file_type);
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

    self.getTeachers = function () {
        self.errors = Constants.FALSE;
        self.teachers = {};

        $scope.ui_block();
        ManagePrincipalContentService.getTeachers(self.principal.school_code).success(function (response) {

            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.teachers = response.data;
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

    self.subjectAreaColumnWidth = function (key, remaining) {
        var num_pages = -1;

        switch (key) {
            case 'progress':
                num_pages = Object.keys(
                    self.student_subject_progress_report.column_header[
                        self.current_page.student_progress]).length;
                break;
            case 'scores':
                num_pages = Object.keys(
                    self.student_subject_scores_report.column_header[
                        self.current_page.student_scores]).length;
                break;
        }

        return remaining / num_pages;
    }

    self.teacherName = function (teacher) {
        return teacher.first_name + ' ' + teacher.last_name;
    }

}