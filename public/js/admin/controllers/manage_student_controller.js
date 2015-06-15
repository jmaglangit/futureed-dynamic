angular.module('futureed.controllers')
	.controller('ManageStudentController', ManageStudentController);

ManageStudentController.$inject = ['$scope', 'manageStudentService', 'apiService',  'TableService', 'SearchService'];

function ManageStudentController($scope, manageStudentService, apiService, TableService, SearchService) {
	var self = this;

	self.students = [{}];
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.getStudentlist = getStudentlist;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		self.searchDefaults();
		self.validation = {};

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST:
			default:
				self.active_list = Constants.TRUE;
				break;
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function getStudentlist() {
		self.errors = Constants.FALSE;
		self.students = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		manageStudentService.getStudentlist(self.search, self.table).success(function(response){

			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.students = response.data.records;
					self.updatePageCount(response.data);
					self.table.loading = Constants.FALSE;
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.searchFnc = function() {
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		} else if(self.active_view) {
			self.getStudent(self.record.id);
		}
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}
}