angular.module('futureed.controllers')
	.controller('TipsController', TipsController);

TipsController.$inject = ['$scope', 'apiService', 'StudentTipsService', 'TableService', 'SearchService'];

function TipsController($scope, apiService, StudentTipsService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.record = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.tipsDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.setTipView = function(tip_id) {
		if(tip_id) {
			self.setActive(Constants.ACTIVE_VIEW, tip_id);
		}
	}

	self.searchFnc = function(event) {
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.listTips();
		}
	}

	self.listTips = function() {
		self.records = [];
		self.errors = Constants.FALSE;
		self.search.class_id = Constants.EMPTY_STR;

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		StudentTipsService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;

					angular.forEach(self.records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);
					});

					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.tipsDetail = function(id) {
		self.errors = Constants.FALSE;
		self.hovered = [];
		self.record = {};

		$scope.ui_block();
		StudentTipsService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.created_at = moment(record.created_at).startOf("minute").fromNow();
					self.record.stars = new Array(5);
					
					self.record.avatar_url = record.student.avatar.avatar_url;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.rating = record.rating;
					self.record.subject_name = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.subject_area_name = (record.subjectarea) ? record.subjectarea.name : Constants.EMPTY_STR;

					self.record.name = record.student.first_name + " " + record.student.last_name;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.changeColor = function(element) {
		self.hovered = [];

		for (i = 0; i <= element; i++ ) {
			self.hovered[i] = Constants.TRUE;			
		}
	}

	self.selectRate = function(rate) {
		self.errors = Constants.FALSE;

		self.data = {};
		self.data.student_id = $scope.user.id;
		self.data.tip_id = self.record.id;
		self.data.rating = self.hovered.length;

		$scope.ui_block();
		StudentTipsService.rate(self.data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record.rating = self.data.rating;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* Events inside a module
	*/
	self.setModuleActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.record = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.getContentTip(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				break;
			
			case Constants.ACTIVE_ADD:
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}
	
	$scope.$on('toggle-tips', function(event) {
		var self = event.currentScope.tips;
		var module = event.targetScope.mod;


		if(!self.show_content_tips) {
			self.show_content_tips = !self.show_content_tips;
		}

		self.module_instance = module;
		self.module = module.record;
		self.question = module.current_question;
		self.content = module.contents;

		self.setModuleActive(Constants.ACTIVE_ADD);
	});

	self.toggleTips = function(module) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.show_content_tips = !self.show_content_tips;
		
		self.module_instance = module;
		self.module = module.record;
		self.question = module.current_question;
		self.content = module.contents;

		self.setActive();
		self.setTipTabActive(Constants.CURRENT);
	}

	self.setTipTabActive = function(active) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		if(!active) {
			active = (self.active_all) ? Constants.ALL : Constants.CURRENT;
		}

		self.searchDefaults();
		self.active_all = Constants.FALSE;
		self.active_current = Constants.FALSE;

		switch(active) {
			case Constants.ALL:
				self.search.link_id = Constants.EMPTY_STR;
				self.search.module_id = self.module.id;
				self.active_all = Constants.TRUE;

				self.listContentTips();
				break;

			case Constants.CURRENT:
				self.search.link_type = (self.module_instance.active_questions) ? Constants.QUESTION : Constants.CONTENT;
				self.search.link_id = (angular.equals(self.search.link_type, Constants.QUESTION)) ? self.question.id : self.content.id;
				self.search.module_id = self.module.id;
				self.active_current = Constants.TRUE;

				self.listContentTips();
			default:
				
				break;
		}
	}

	self.viewTipList = function() {
		self.setModuleActive();
		self.setTipTabActive();
	}

	self.listContentTips = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		$scope.div_block('tip_list');
		StudentTipsService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;

					angular.forEach(self.records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);
					});

					self.updatePageCount(response.data);
				}
			} else {
				self.errors = $scope.errorHandler(response.errors);
			}

			$scope.div_unblock('tip_list');
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock('tip_list');
		});
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record.module_id = self.module.id;
		self.record.subject_id = self.module.subject_id;
		self.record.subject_area_id = self.module.subject_area_id;
		self.record.link_type = (self.active_questions) ? Constants.QUESTION : Constants.CONTENT;
		self.record.link_id = (angular.equals(self.record.link_type, Constants.QUESTION)) ? self.question.id : self.content.id;
		self.record.class_id = $scope.user.class.id;
		self.record.student_id = $scope.user.id;

		$scope.div_block('add_tip');
		StudentTipsService.addTip(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.record = {};
				}
			}
			$scope.div_unblock('add_tip');
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.div_unblock('add_tip');
		})
	}

	self.getContentTip = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.div_block('tip_details');
		StudentTipsService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.created_at = moment(record.created_at).startOf("minute").fromNow();
					self.record.stars = new Array(5);
					
					self.record.avatar_url = record.student.avatar.avatar_url;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.rating = record.rating;
					self.record.subject_name = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.subject_area_name = (record.subjectarea) ? record.subjectarea.name : Constants.EMPTY_STR;

					self.record.name = record.student.first_name + " " + record.student.last_name;
				}
			}

			$scope.div_unblock('tip_details');
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock('tip_details');
		});
	}
}
