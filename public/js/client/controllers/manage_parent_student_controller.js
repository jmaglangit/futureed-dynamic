angular.module('futureed.controllers')
	.controller('ManageParentStudentController', ManageParentStudentController);

ManageParentStudentController.$inject = ['$scope', 'ManageParentStudentService', 'apiService', 'TableService', 'SearchService'];

function ManageParentStudentController($scope, ManageParentStudentService, apiService, TableService, SearchService) {
	var self = this;

	self.students = [{}];
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.existActive = function(req) {
		
		switch(req) {
			case 'new':
				self.exist = Constants.TRUE;
				break
			case 'old':
			default:
				self.exist = Constants.FALSE;
				break
		}
	}

	self.setActive = function(active) {

		switch(active) {
			case Constants.ACTIVE_EDIT:
				self.edit_form = Constants.TRUE;
				self.disabled = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				self.active_edit = Constants.FALSE;
				self.active_add = Constants.FALSE;
				break;
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

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		} else if(self.active_view) {
			self.getStudent(self.record.id);
		}
	}

	self.getStudentlist = function() {
		self.errors = Constants.FALSE;
		self.students = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		ManageParentStudentService.getStudentlist(self.search, self.table).success(function(response){

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