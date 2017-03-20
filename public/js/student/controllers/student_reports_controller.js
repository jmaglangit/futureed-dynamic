angular.module('futureed.controllers')
    .controller('StudentReportsController', StudentReportsController);

StudentReportsController.$inject = ['$scope', '$timeout', 'StudentReportsService', 'SearchService'];

function StudentReportsController($scope, $timeout, StudentReportsService, SearchService) {
    var self = this;

    SearchService(self);
    self.searchDefaults();

    self.setActive = function (active) {
        self.records = {};
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;

        self.active_report_card = Constants.FALSE;
        self.active_summary_progress = Constants.FALSE;
        self.active_add = Constants.FALSE;
        self.active_current_learning = Constants.FALSE;
        self.active_subject_area = Constants.FALSE;
        self.active_subject_area_heatmap = Constants.FALSE;
        self.student_report_export = Constants.FALSE;
        self.active_lsp_download = Constants.FALSE;
        self.active_question_analysis = Constants.FALSE;
        self.student_question_analysis_export = Constants.FALSE;
        self.chart_load = Constants.FALSE;


        self.searchDefaults();

        switch (active) {
            case    Constants.SUMMARY_PROGRESS    :
                self.active_summary_progress = Constants.TRUE;
                self.listSubjects();
                break;

            case Constants.REPORT_CARD            :
                self.active_report_card = Constants.TRUE;
                self.reportCard();
                break;

            case Constants.CURRENT_LEARNING        :
                self.active_current_learning = Constants.TRUE;
                self.listLearning();
                break;

            case Constants.SUBJECT_AREA            :
                self.active_subject_area = Constants.TRUE;
                self.listSubjectAreaSubject();
                break;

            case Constants.SUBJECT_AREA_HEATMAP    :
                self.active_subject_area_heatmap = Constants.TRUE;
                self.listSubjectAreaHeatmapSubject();
                break;

            case Constants.QUESTION_ANALYSIS       :
                self.active_question_analysis = Constants.TRUE;
                break;

            default                                :
                self.active_report_card = Constants.TRUE;
                $scope.getGradeLevel($scope.user.user.curriculum_country);
                self.listSubjects();
                self.reportCard();
                break;
        }
    }

    self.reportCard = function () {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        StudentReportsService.reportCard($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.records = response.data.rows.map(function(row) {
                        row.module_status = row.module_status == Constants.FAILED ? Constants.RETAKE : row.module_status;
                        return row;
                    });

                    self.student = response.data.additional_information;
                    self.getIAssessReportLink();
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.summaryProgress = function (subject_id) {
        self.errors = Constants.FALSE;
        self.summary = {};

        self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

        $scope.ui_block();
        StudentReportsService.summaryProgress($scope.user.id, self.search.subject_id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.summary.columns = response.data.column_header[0];

                    $timeout(function () {
                        self.summary.records = response.data.rows.progress;
                        self.student = response.data.additional_information;

                        angular.forEach(self.summary.records, function (value, key) {
                            value.completed = value.completed + "%";
                            value.on_going = value.on_going + "%";
                        });
                    }, 500);
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.listSubjects = function () {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        StudentReportsService.listClass($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data.records;
                    if (data.length) {
                        self.subjects = [];

                        angular.forEach(data, function (value, key) {
                            self.subjects[key] = value.classroom.subject;
                        });

                        self.summaryProgress(self.subjects[0].id);
                    }
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.listLearning = function () {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        StudentReportsService.listClass($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data.records;
                    if (data.length) {
                        self.subjects = [];

                        angular.forEach(data, function (value, key) {
                            self.subjects[key] = value.classroom.subject;
                        });

                        self.currentLearning(self.subjects[0].id);
                    }
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.currentLearning = function (subject_id) {
        self.errors = Constants.FALSE;
        self.summary = {};
        self.grade_name = '';

        self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

        $scope.ui_block();
        StudentReportsService.currentLearning($scope.user.id, self.search.subject_id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.summary.columns = response.data.column_header;

                    self.row_data = {};
                    var data = response.data.rows;
                    var raw_grade = 0;

                    angular.forEach(data, function (value, key) {

                        if (value.grade_id == raw_grade) {

                            value.grade_name = '';
                            self.row_data[key] = value;
                        } else {

                            raw_grade = value.grade_id;
                        }
                    });

                    self.summary.records = response.data.rows;

                    self.student_report_export = '/api/report/student-progress/current-learning/' + $scope.user.id +'/' + self.search.subject_id;
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.listSubjectAreaSubject = function () {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        StudentReportsService.listClass($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data.records;
                    if (data.length) {
                        self.subjects = [];

                        angular.forEach(data, function (value, key) {
                            self.subjects[key] = value.classroom.subject;
                        });

                        self.subjectArea(self.subjects[0].id);
                    }
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.subjectArea = function (subject_id) {
        self.errors = Constants.FALSE;
        self.summary = {};

        self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

        $scope.ui_block();
        StudentReportsService.subjectArea($scope.user.id, self.search.subject_id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.summary.columns = response.data.column_header;
            
                    var column = response.data.column_header;

                    angular.forEach(column, function (value, key){


                    });

                    self.summary.records = response.data.rows;
                    self.student = response.data.additional_information;
                    self.student_report_export = '/api/report/student-progress/curriculum/' + $scope.user.id +'/' + self.search.subject_id;
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });

    }

    self.listSubjectAreaHeatmapSubject = function () {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        StudentReportsService.listClass($scope.user.id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data.records;
                    if (data.length) {
                        self.subjects = [];

                        angular.forEach(data, function (value, key) {
                            self.subjects[key] = value.classroom.subject;
                        });

                        self.subjectAreaHeatmap(self.subjects[0].id);
                    }
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.subjectAreaHeatmap = function (subject_id) {
        self.errors = Constants.FALSE;
        self.summary = {};

        self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

        $scope.ui_block();
        StudentReportsService.subjectAreaHeatmap($scope.user.id, self.search.subject_id).success(function (response) {
            if (angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.summary.columns = response.data.column_header;

                    self.summary.records = response.data.rows;
                    self.student = response.data.additional_information;
                    self.student_report_export = '/api/report/student-progress/curriculum/heat-map/' + $scope.user.id +'/' + self.search.subject_id;
                }
            }

            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });

    }

    self.getIAssessReportLink = function(){

        $scope.ui_block();
        StudentReportsService.getIAssessDownloadLinkReport($scope.user.id).success(function (response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.student_iassess_report = response.data;
                    self.active_lsp_download = Constants.TRUE;
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }


    //get student question analysis
    self.getQuestionAnalysis = function(){
        self.question_analysis = Constants.FALSE;

        //initialize parameters for report
        self.question_analysis_param = {
            student_id  :   $scope.user.id,
            subject_id  :   self.search.subject_id,
            grade_id    :   self.search.grade_id,
            module_id   :   self.search.module_id
        };

        //get subject class
        $scope.ui_block;
        StudentReportsService.questionAnalysis(self.question_analysis_param).success(function (response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data){
                    var data = response.data;
                    self.question_analysis = data;
                    self.student_question_analysis_export = Constants.TRUE

                    //setup downloadable PDF link
                    self.student_question_analysis_export_link = '/api/report/student-progress/question-analysis'
                        + '?student_id=' + self.question_analysis_param.student_id
                        + '&subject_id=' + self.question_analysis_param.subject_id
                        + '&grade_id='   + self.question_analysis_param.grade_id
                        + '&module_id='  + self.question_analysis_param.module_id;
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //get list of modules by subject and level
    self.getModuleList = function(){

        //get country
        //if module and grade is not null get module list
        if(self.search.subject_id > Constants.FALSE && self.search.grade_id > Constants.FALSE){

            //get module list
            $scope.getGradeCountry(
                $scope.user.user.curriculum_country,
                Constants.EMPTY_STR,
                self.search.grade_id,
                self.search.subject_id
            );
        } else {
            self.student_question_analysis_export = Constants.FALSE;
        }
    }

    //get student monthly spent hours
    self.getStudentMonthlySpentHours = function(){

        StudentReportsService.getStudentChartMonthHours($scope.user.id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data){
                    var data = response.data;

                    //transfer variable into object
                    var chart_data = [];

                    //this week
                    chart_data.push({
                        letter: (data.seven_days) ? data.seven_days.report_name : "Last Seven Days",
                        frequency: (data.seven_days) ? data.seven_days.hours_spent : 0
                    });

                    //add this month
                    chart_data.unshift({
                        letter: (data.this_month) ? data.this_month.report_name : "This Month",
                        frequency: (data.this_month) ? data.seven_days.hours_spent : 0
                    });

                    //add last month
                    chart_data.unshift({
                        letter: (data.last_month) ? data.last_month.report_name : "Last Month",
                        frequency: (data.last_month) ? data.last_month.hours_spent : 0
                    });

                    //call to generate chart.
                    platformChartMonthly(chart_data);

                }
            }


        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //get student weekly spent hours
    self.getStudentWeeklySpentHours = function(){

        StudentReportsService.getStudentChartWeekHours($scope.user.id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data;

                    //transfer variable into object
                    self.weekly_hours = [];

                    angular.forEach(data,function(a){
                        self.weekly_hours.unshift({
                            letter: a.week_name,
                            frequency: (a.activity) ? a.activity.hours_spent : 0
                        });
                    });

                    //call to generate chart
                    platformChartWeekly(self.weekly_hours);

                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //get student subject area
    self.getStudentChartSubjectArea = function(subject_id,grade_id){

        self.subject_area_subject_id = (subject_id == Constants.NULL)
            ? self.search.subject_id : subject_id;
        self.subject_area_grade_id = grade_id;

        var data = {
            student_id  :   $scope.user.id,
            subject_id  :   self.subject_area_subject_id,
            grade_id    :   self.subject_area_grade_id
        };

        StudentReportsService.getStudentChartSubjectArea(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data;

                    //transfer variable into object
                    self.chart_subject_area = [];

                    angular.forEach(data,function(a){

                        self.chart_subject_area.push({
                            letter : a.curriculum_name,
                            frequency : (a.curriculum_data.length > Constants.FALSE)
                                ? (a.curriculum_data[0].progress/100) : 0
                        });
                    });

                    platformSubjectArea(self.chart_subject_area);
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //get student subject area heatmap
    self.getStudentChartSubjectAreaHeatMap = function(subject_id,grade_id){

        self.area_heatmap_subject_id = (subject_id == Constants.NULL) ? self.search.subject_id : subject_id;
        self.area_heatmap_grade_id = grade_id;

        var data = {
            student_id  :   $scope.user.id,
            subject_id  :   self.area_heatmap_subject_id,
            grade_id    :   self.area_heatmap_grade_id
        };

        StudentReportsService.getStudentChartSubjectAreaHeatMap(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if (response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    var data = response.data;

                    //transfer variable into object
                    self.chart_subject_area_heatmap = [];

                    //transfer variable into object
                    self.chart_subject_area_heatmap = [];

                    angular.forEach(data,function(a){

                        self.chart_subject_area_heatmap.push({
                            letter : a.curriculum_name,
                            frequency : (a.curriculum_data.length > Constants.FALSE)
                                ? (a.curriculum_data[0].heat_map/100) : 0
                        });
                    });

                    platformSubjectAreaHeatMap(self.chart_subject_area_heatmap);

                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });

    }
}