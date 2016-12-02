angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', '$filter', '$window', 'StudentClassService', 'SearchService', 'TableService'];

function StudentClassController($scope, $filter, $window, StudentClassService, SearchService, TableService) {
	var self = this;

	self.tips = {};
	self.help = {};
	self.total_module_items_loaded = Constants.DEFAULT_SIZE;
	SearchService(self);
	self.searchDefaults();

	self.previousPage = function()
	{
		if(self.table.page > 1)
		{
			self.total_module_items_loaded -= self.table.size;
			self.table.page--;
			self.paginateByPage();
		}
	}

	self.nextPage = function()
	{
		if(self.total_module_items_loaded < self.table.total_items)
		{
			self.total_module_items_loaded += self.table.size;
			self.table.page++;
			self.paginateByPage();
		}
	}

	TableService(self);
	self.tableDefaults();

	self.setCurrentClass = function(class_id) {
		if(parseInt(class_id)) {
			var class_id = parseInt(class_id),
				is_class_ok = parseInt($scope.user_classes.indexOf(class_id) + 1) > Constants.FALSE, // check if class is valid (paid)
				user_class = is_class_ok ? parseInt(class_id) : $scope.user_classes[Constants.FALSE] || Constants.FALSE; // if class ok : assign class_id, else : assign first class id, else : 0

			self.current_class = user_class;
			$scope.user.class = user_class;
			$scope.updateUserData($scope.user);

			self.handleClassHref(is_class_ok, user_class);
		}
	}

	// update href automatically (if class ok) with valid(paid/active) class, else redirect to student dashboard
	self.handleClassHref = function(is_class_ok, user_class) {
		if(!is_class_ok) {
			if(user_class) {
				$window.history.pushState('', '', '/student/class/' + user_class);
			} else {
				if($window.location.pathname !== '/student/dashboard') {
					$window.location.href = '/student/dashboard';
				}
			}
		}
	}

	self.redirectClass = function(url, class_id) {
		if(parseInt(class_id) && self.current_class != class_id) {
			$window.location.href = url + "/" + class_id;	
		}
	}

	self.redirectHelp = function(help_id, request_type) {
		var url = $("#redirect_help").prop('action');
			url += "/" + self.current_class;

		if(help_id) {
			$("#redirect_help input[name='id']").val(help_id);
		}

		if(request_type) {
			$("#redirect_help input[name='request_type']").val(request_type);
		}
		
		$("#redirect_help").prop('action', url);
		$("#redirect_help").submit();
	}

	self.redirectTip = function(tip_id) {
		var url = $("#redirect_tip").prop('action');
			url += "/" + self.current_class;

		if(tip_id) {
			$("#redirect_tip input[name='id']").val(tip_id);
		}
		
		$("#redirect_tip").prop('action', url);
		$("#redirect_tip").submit();
	}

	self.click = function() {
		self.bool_change_class = !self.bool_change_class;

		if(self.bool_change_class) {
			self.add_tips = Constants.FALSE;
			self.add_help = Constants.FALSE;

			self.listTips();
			self.listHelpRequests();
		}
	}

	self.addTips = function() {
		self.tips = {};
		self.add_tips = Constants.TRUE;
	}

	self.backTips = function() {
		self.tips = {};
		self.add_tips = Constants.FALSE;

		self.listTips();
	}

	self.submitTips = function() {
		self.tips.errors = Constants.FALSE;
		self.tips.success = Constants.FALSE;
		self.tips.student_id = $scope.user.id;
		self.tips.class_id = (self.current_class) ? self.current_class : Constants.EMPTY_STR;

		$scope.div_block("tips_form");
		StudentClassService.submitTips(self.tips).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.tips.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tips.success = Constants.TRUE;
					self.add_tips = Constants.FALSE;
				}
			}
			$scope.div_unblock("tips_form");
		}).error(function(response){
			self.tips.errors = $scope.internalError();
			$scope.div_unblock("tips_form");
		})
	}

	self.addHelp = function() {
		self.help = {};
		self.add_help = Constants.TRUE;
	}

	self.backHelp = function() {
		self.help = {};
		self.add_help = Constants.FALSE;

		self.listHelpRequests();
	}

	self.submitHelp = function() {
		self.help.errors = Constants.FALSE;
		self.help.success = Constants.FALSE;
		self.help.student_id = $scope.user.id;
		self.help.class_id = (self.current_class) ? self.current_class : Constants.EMPTY_STR;

		$scope.div_block("help_request_form");
		StudentClassService.submitHelp(self.help).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.help.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help.success = Constants.TRUE;
					self.add_help = Constants.FALSE;
				}
			}
			$scope.div_unblock("help_request_form");
		}).error(function(response){
			self.help.errors = $scope.internalError();
			$scope.div_unblock("help_request_form");
		})
	}
	
	self.listTips = function() {
		self.errors = Constants.FALSE;
		
		self.tipsSearch = {};
		self.tipsSearch.class_id = (self.current_class) ? self.current_class : Constants.EMPTY_STR;
		self.tipsSearch.link_type = Constants.GENERAL;

		self.tipsTable = {};
		self.tipsTable.size = 3;
		self.tipsTable.offset = Constants.FALSE;

		$scope.div_block("tips_form");
		StudentClassService.listTips(self.tipsSearch, self.tipsTable).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tips = {};
					self.tips.records = response.data.records;
					self.tips.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);
					});
				}
			}

			$scope.div_unblock("tips_form");
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock("tips_form");
		});
	}

	self.listHelpRequests = function() {
		self.errors = Constants.FALSE;

		self.helpRequestsSearch = {};
		self.helpRequestsSearch.order_by_date = Constants.TRUE;
		self.helpRequestsSearch.link_type = Constants.GENERAL;
		self.helpRequestsSearch.request_status = Constants.ACCEPTED;
		self.helpRequestsSearch.class_id = (self.current_class) ? self.current_class : Constants.EMPTY_STR;

		self.helpRequestsTable = {};
		self.helpRequestsTable.size = 3;
		self.helpRequestsTable.offset = Constants.FALSE;

		$scope.div_block("help_request_form");
		StudentClassService.listHelpRequests(self.helpRequestsSearch, self.helpRequestsTable).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help = {};
					self.help.records = [];
					self.help.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);

						self.help.records.push(value);
					});
				}
			}

			$scope.div_unblock("help_request_form");
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock("help_request_form");
		});
	}

	self.searchFnc = function(event) {
		self.total_module_items_loaded = Constants.DEFAULT_SIZE;
		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();
		self.list();
	}

	self.list = function() {
		self.listModules();
	}

	self.listClass = function() {
		self.errors = Constants.FALSE;
		var student_id = $scope.user.id;

		$scope.ui_block();
		StudentClassService.listClass(student_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classes = response.data.records;

					if(self.classes.length) {
						if(!self.current_class) {
							self.current_class = self.classes[0].class_id;
						}

						self.listModules();
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listModules = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		self.search.class_id = self.current_class;
		self.search.student_id = $scope.user.id;

		if (self.search.grade_id) {
			angular.forEach($scope.grades, function(value,key){
				if(value.id == self.search.grade_id){
					self.grade_name = value.name;
				}
			});
		} else {
			self.grade_name = Constants.EMPTY_STR;
		}

		$scope.ui_block();
		StudentClassService.listModules(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.student_classroom.student_subject.student_modules.records;
					self.updatePageCount(response.data.student_classroom.student_subject.student_modules);

					angular.forEach(self.records, function(value, key) {
						value.progress = (value.progress) ? value.progress : Constants.FALSE;
					});
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getSubjects = function() {
		StudentClassService.getSubjects().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
				}
			}

		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.redirect = function(url, record) {
		if($scope.user.points >= record.points_to_unlock) {
			url += "/" + record.id;
			$window.location.href = url;
		}
	}

	self.updateBackground = function() {

		StudentClassService.getStudentBackgroundImage($scope.user.user.id).success(function(response){
			if(response.data){
				angular.element('body.student').css({
					'background-image' : 'url("' + response.data.url + '")'
				});
			}else{
				angular.element('body.student').css({
					'background-image' : 'url("/images/class-student/mountain-full-bg.png")'
				});
			}
		}).error(function(response){
			self.error = $scope.internalError();
		});
	}

	self.downloadCurriculumPDF = function(){
		var data = {};
		data.grade_id = self.search.grade_id;
		angular.forEach(self.classes, function(value, key){
			if(value.classroom.id == self.current_class){
				data.subject_id = value.classroom.subject.id;
				data.curriculum_country = value.student.user.curriculum_country;
			}
		});

		StudentClassService.downloadCurriculumPDF(data).success(function(response,status,headers){
			try{
				var decodedString = String.fromCharCode.apply(null, new Uint8Array(response));
				var obj = JSON.parse(decodedString);
				if(obj.errors){
					self.errors = $scope.errorHandler(obj.errors);
				}
			} catch(e){
				var content_dispostion = headers('content-disposition');
				var result = content_dispostion.split(";")[1];
				result = result.replace('\"','').replace('\"','');
				result = result.split("=")[1];
				var file = new Blob([response], { type: 'application/pdf' });
				saveAs(file, result);
			}

		});
	}
}