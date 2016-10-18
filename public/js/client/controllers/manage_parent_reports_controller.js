angular.module('futureed.controllers')
	.controller('ManageParentReportsController', ManageParentReportsController);

ManageParentReportsController.$inject = ['$scope', '$timeout', 'ManageParentReportsService', 'SearchService'];

function ManageParentReportsController($scope, $timeout, ManageParentReportsService, SearchService) {
	var self = this;
	SearchService(self);
    self.searchDefaults();

	self.active_report = Constants.FALSE;
	self.student_id = Constants.FALSE;

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
		self.active_question_analysis = Constants.FALSE;

		self.searchDefaults();

		switch (active) {
			case Constants.SUMMARY_PROGRESS    :
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

			case Constants.SUBJECT_AREA_HEATMAP	:
				self.active_subject_area_heatmap = Constants.TRUE;
				self.listSubjectAreaHeatmapSubject();
				break;

			case Constants.QUESTION_ANALYSIS	:
				self.listSubjects();
				$scope.getGradeLevel(self.curriculum_country);
				self.active_question_analysis = Constants.TRUE;
				break;

			default                                :
				self.active_report_card = Constants.TRUE;
				self.listStudents();
				self.reportCard();
				break;
		}
	}

	self.reportCard = function () {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentReportsService.reportCard(self.student_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.records = response.data.rows;
					self.student = response.data.additional_information;
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
		ManageParentReportsService.summaryProgress(self.student_id, self.search.subject_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					var data = [];

					angular.forEach(response.data.column_header[0],function(value,key){
						data.push({
							'grade'	:	value,
							'key'	:	key
						});
					});

					self.summary.columns = data;

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
		ManageParentReportsService.listClass(self.student_id).success(function (response) {
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
		ManageParentReportsService.listClass(self.student_id).success(function (response) {
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
		ManageParentReportsService.currentLearning(self.student_id, self.search.subject_id).success(function (response) {
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
		ManageParentReportsService.listClass(self.student_id).success(function (response) {
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
		ManageParentReportsService.subjectArea(self.student_id, self.search.subject_id).success(function (response) {
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
		ManageParentReportsService.listClass(self.student_id).success(function (response) {
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
		ManageParentReportsService.subjectAreaHeatmap(self.student_id, self.search.subject_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.summary.columns = response.data.column_header;

					var column = response.data.column_header;

					self.summary.records = response.data.rows;
					self.student = response.data.additional_information;
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listStudents = function() {
		self.student_list = {};

		$scope.ui_block();
		ManageParentReportsService.listStudents($scope.user.id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.total) {
						var list = [];
						self.active_report = Constants.TRUE;
						self.student_list = response.data.records;

						for (var i = 0; i < self.student_list.length; i++) {
							if (self.student_list[i].parent.status == Constants.ENABLED) {
								list.push(
									{
										id: self.student_list[i].id,
										first_name: self.student_list[i].first_name,
										last_name: self.student_list[i].last_name,
										curriculum_country: self.student_list[i].user.curriculum_country
									}
								);
							}
						}
						self.enabled_lists = list;
						self.changeStudentId(self.enabled_lists[0]);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.changeStudentId = function(student){
		self.student_id = (self.student_id) ? self.student_id : student.id;
		self.curriculum_country = (self.curriculum_country) ? self.curriculum_country : student.curriculum_country;
		self.setActive(Constants.REPORT_CARD);
	}

	self.getQuestionAnalysis = function(){
		self.question_analysis = Constants.FALSE;

		//initialize parameters for report
		self.question_analysis_param = {
			student_id  :   self.student_id,
			subject_id  :   self.search.subject_id,
			grade_id    :   self.search.grade_id,
			module_id   :   self.search.module_id
		};

		//get subject class
		$scope.ui_block;
		ManageParentReportsService.questionAnalysis(self.question_analysis_param).success(function (response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					var data = response.data;
					self.question_analysis = data;
					self.student_question_analysis_export = Constants.TRUE
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
				self.curriculum_country,
				Constants.EMPTY_STR,
				self.search.grade_id,
				self.search.subject_id
			);
		} else {
			self.student_question_analysis_export = Constants.FALSE;
		}
	}
}