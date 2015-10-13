angular.module('futureed.controllers')
	.controller('ManageLogsController', ManageLogsController);

ManageLogsController.$inject = ['$scope', 'ManageLogsService', 'TableService', 'SearchService'];

function ManageLogsController($scope, ManageLogsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		self.records = {};

		self.active_security_log = Constants.FALSE;
		self.active_users_log = Constants.FALSE;
		self.active_administrator_log = Constants.FALSE;
		self.active_system_log = Constants.FALSE;
		self.active_errors_log = Constants.FALSE;

		switch(active) {

			case Constants.ADMINISTRATOR	:
				self.active_administrator_log = Constants.TRUE;
				self.adminLogs();
				break;

			case Constants.USERS			:
				self.active_users_log = Constants.TRUE;
				self.userLogs();
				break;

			case Constants.SYSTEM			:
				self.active_system_log = Constants.TRUE;
				self.systemLogs();
				break;

			case Constants.ERRORS			:
				self.active_errors_log = Constants.TRUE;
				self.errorLogs();
				break;

			case Constants.SECURITY			:
			
			default:
				self.active_security_log = Constants.TRUE;
				self.securityLogs();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.list();
	}

	self.clearFnc = function() {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		if(self.active_security_log) {
			self.securityLogs();
		} else if(self.active_administrator_log) {
			self.adminLogs();
		} else if(self.active_users_log) {
			self.userLogs();
		}
	}

	self.securityLogs = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageLogsService.securityLogs(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.records = response.data.rows.record;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.adminLogs = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageLogsService.adminLogs(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.records = response.data.rows.record;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.userLogs = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageLogsService.userLogs(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.records = response.data.rows.record;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.systemLogs = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageLogsService.systemLogs().success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.rows = response.data.rows;

					self.records = [];
					angular.forEach(self.rows, function(value, key) {
						var data = {
							'name'		: value 
							, 'path'	: self.setSystemDownloadLink(value)
						}

						self.records.push(data);

					});
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.errorLogs = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageLogsService.errorLogs().success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.rows = response.data.rows;

					self.records = [];
					angular.forEach(self.rows, function(value, key) {
						var data = {
							'name'		: value 
							, 'path'	: self.setErrorDownloadLink(value)
						}

						self.records.push(data);

					});
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setSystemDownloadLink = function(filename) {
		return ManageLogsService.downloadSystemLog(filename);
	}

	self.setErrorDownloadLink = function(filename) {
		return ManageLogsService.downloadErrorLog(filename);
	}
}