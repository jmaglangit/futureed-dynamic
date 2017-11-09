angular.module('futureed.controllers')
	.controller('ManagePrincipalTeacherController', ManagePrincipalTeacherController);

ManagePrincipalTeacherController.$inject = ['$scope', 'ManagePrincipalTeacherService', 'clientProfileApiService', 'apiService'
	, 'TableService', 'SearchService', 'ValidationService'];

function ManagePrincipalTeacherController($scope, ManagePrincipalTeacherService, clientProfileApiService, apiService, TableService, SearchService, ValidationService){
	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	ValidationService(self);
	self.default();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.records = {};
		self.record = {};
		self.fields = [];

		self.tableDefaults();
		self.searchDefaults();

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_delete = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD	:
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW	:
				self.active_view = Constants.TRUE;
				self.details(id);
				self.classDetails(id);
				break;

			case Constants.ACTIVE_EDIT	:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_LIST :

			default:
				self.active_list = Constants.TRUE;
				break
		}

	    $("html, body").animate({ scrollTop: 0 }, "slow");			
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.tableDefaults();
		self.searchDefaults();
		
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.listRecords();
		} else if(self.active_view) {
			self.classDetails(self.record.id);
		}
	}

	self.listRecords = function() {
		self.errors = Constants.FALSE;
		self.records = [];

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		clientProfileApiService.getClientDetails($scope.user.id).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$scope.ui_unblock();
				} else if(response.data) {
					self.search.school_code = response.data.school_code;

					ManagePrincipalTeacherService.list(self.search, self.table).success(function(response){
						self.table.loading = Constants.FALSE;

						if(angular.equals(response.status, Constants.STATUS_OK)){
							if(response.errors) {
								self.errors = $scope.errorHandler(response.errors);
							} else if(response.data) {
								self.records = response.data.records;
								self.updatePageCount(response.data);
							}
						}

						$scope.ui_unblock();
					}).error(function(response){
						self.table.loading = Constants.FALSE;
						self.errors = $scope.internalError();
						$scope.ui_unblock();
					})
				}
			}
		}).error(function(response){
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.save = function(callback_uri) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.validation = {};
		self.fields = [];

		self.record.callback_uri = callback_uri;
		self.record.current_user = $scope.user.id;

		$scope.ui_block();
		ManagePrincipalTeacherService.save(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Account");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	}

	self.details = function(id) {
		self.record = Constants.FALSE;

		$scope.ui_block();
		ManagePrincipalTeacherService.details(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.classDetails = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.classes = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManagePrincipalTeacherService.classDetails(id, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classes = response.data.record;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.table.loading = Constants.FALSE;
			$scope.ui_unblock();
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];

		$scope.ui_block();
		ManagePrincipalTeacherService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data){
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = Constants.MSG_UPDATED("Account");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;
		
		$("#delete_teacher_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.delete = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManagePrincipalTeacherService.delete(self.record.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Account");
				}
 			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}