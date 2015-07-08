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
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;

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
		self.search.class_id = ($scope.user.class) ? $scope.user.class.class_id : Constants.EMPTY_STR;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		StudentTipsService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
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
					self.record.created_moment = moment(record.created_at).startOf("minute").fromNow();
					self.record.stars = new Array(5);
					
					self.record.avatar_url = record.student.avatar.avatar_url;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.rating = record.rating;
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
}
