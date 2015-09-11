angular.module('futureed.controllers')
	.controller('ManageAdminController', ManageAdminController);

ManageAdminController.$inject = ['$scope', 'ManageAdminService', 'TableService', 'SearchService', 'ValidationService'];

function ManageAdminController($scope, ManageAdminService, TableService, SearchService, ValidationService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	ValidationService(self);
	self.default();

	self.user_type = Constants.ADMIN;
	

	self.setActive = function(active, id){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];
		self.change = {};
		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_add  = Constants.FALSE
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_edit_email = Constants.FALSE;
		self.active_edit_pass  = Constants.FALSE;

		switch(active){
			case 'pass' :
				self.active_edit_pass = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD :
				self.record = {};
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW :
				self.viewAdmin(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.viewAdmin(id);
				self.active_edit = Constants.TRUE;
				break;

			case 'edit_email' :
				self.active_edit_email = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST :
			default:
				self.record = {};
				self.getAdminList();
				self.active_list = Constants.TRUE;
				break;
		} 

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.getAdminList = function(){
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageAdminService.getAdminList(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.data = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clearSearch = function(){
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.getAdminList();
	}

	self.saveAdmin = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.fields = [];
		self.validation = {};
		
		if(!angular.equals(self.record.password, self.record.confirm_password)){
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			self.fields["password"] = Constants.TRUE;
			$("html, body").animate({ scrollTop: 0 }, "slow");
		} else {
			$scope.ui_block();
			ManageAdminService.saveAdmin(self.record).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key){
							self.fields[value.field] = Constants.TRUE;
						});

					}else if(response.data){
						self.record = {};
						self.success = ["You have successfully created an administrator."];
						$("html, body").animate({ scrollTop: 0 }, "slow");
					}
				}

				$scope.ui_unblock();
			}).error(function(response){
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	self.viewAdmin = function(id){
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageAdminService.viewAdmin(id).success(function(response) {
			if(angular.equals(response.status,Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					var data = response.data;

					self.record = {
						 id 				: data.id
						, email 			: data.user.email
						, username			: data.user.username
						, status			: data.user.status
						, admin_role		: data.admin_role
						, first_name		: data.first_name
						, last_name			: data.last_name
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateAdmin = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.fields = [];
		self.validation = {};

		$scope.ui_block();
		ManageAdminService.editAdmin(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data){
					self.success = ["Successfully updated this profile."];

					self.viewAdmin(response.data.id);
					self.active_edit = Constants.FALSE;
					self.active_view = Constants.TRUE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.ui_unblock();
			self.errors = $scope.internalError();
		});

	}

	self.resetPassword = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		if(self.change.new_password != self.change.confirm_password){
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			self.fields["new_password"] = Constants.TRUE;
			self.fields["confirm_password"] = Constants.TRUE;
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}else{
			$scope.ui_block();
			ManageAdminService.resetPass(self.change.new_password, self.record.id).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key){
							self.fields[value.field] = Constants.TRUE;
						});
					}else if(response.data){
						self.reset_success = Constants.TRUE;
					}
				}
				
				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			})
		}
	}

	self.confirmDelete = function(id){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.delete_id = id;
		self.delete_confirm = Constants.TRUE;
		
		$("#delete_admin_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteModeAdmin = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageAdminService.deleteModeAdmin(self.delete_id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = ["You have successfully deleted the selected administrator."];
					self.getAdminList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.changeAdminEmail = function() {
		self.errors = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.ADMIN);

	    if(!angular.equals(self.change.new_email, self.change.confirm_email)){
			self.errors = [Constants.MSG_EA_NOT_MATCH];
			self.fields["new_email"] = Constants.TRUE;
			self.fields["confirm_email"] = Constants.TRUE;
			$("html, body").animate({ scrollTop: 0 }, "slow");
		} else {
			$scope.ui_block();
			ManageAdminService.changeAdminEmail(self.record.id, self.change.new_email, callback_uri).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key){
							self.fields[value.field] = Constants.TRUE;
						});
					} else if(response.data) {
						self.success = ["Successfully updated the email address."];

						self.viewAdmin(self.record.id);
						self.active_edit_email = Constants.FALSE;
						self.active_view = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}
}