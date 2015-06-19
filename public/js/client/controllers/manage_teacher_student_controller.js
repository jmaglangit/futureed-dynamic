angular.module('futureed.controllers')
	.controller('ManageTeacherStudentController', ManageTeacherStudentController);

ManageTeacherStudentController.$inject = ['$scope', 'ManageTeacherStudentService', 'apiService', 'TableService', 'SearchService'];

function ManageTeacherStudentController($scope, ManageTeacherStudentService, apiService, TableService, SearchService) {
	var self = this;

	self.students = [{}];
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.searchDefaults();


		switch(active) {

			case Constants.LIST:
			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		} else if(self.active_view) {
			self.getStudent(self.record.id);
		}
	}

	self.searchFnc = function() {
		self.list();
		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}

	self.getStudentlist = function() {
		self.errors = Constants.FALSE;
		self.students = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		ManageTeacherStudentService.getStudentlist(self.search, self.table).success(function(response){

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
}