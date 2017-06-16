angular.module('futureed.controllers')
	.controller('ManageQuestionTempController', ManageQuestionTempController);

ManageQuestionTempController.$inject = ['$scope', 'ManageQuestionTempService', 'TableService', 'SearchService', 'Upload'];

function ManageQuestionTempController($scope, ManageQuestionTempService, TableService, SearchService, Upload) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};
		self.record = {};
		self.record.question_template_format = '';
		self.record.question_equation = '';
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_update = Constants.FALSE;
		self.active_questions_preview = Constants.FALSE;
		self.question_preview_id = "#questions_preview";
		self.curriculum_country = Constants.FALSE;
		self.checkbox_all = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.active_update = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_VIEW :
				self.active_view = Constants.TRUE;
				self.module_table = self.table;
				self.details(id);

				self.detail_hidden = Constants.FALSE;
				self.content_hidden = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD :
				self.tableDefaults();
				self.searchDefaults();
				self.active_add = Constants.TRUE;
				break;

			case Constants.HIDE_MODULE:
				self.active_list = Constants.TRUE;
				self.setPage(self.module_table);
				break;

			default:
				self.active_list = Constants.TRUE;
				self.tableDefaults();
				self.searchDefaults();
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.toggleDetail = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var detail_shown = $('#module_detail').hasClass('in');

		if(detail_shown) {
			self.detail_hidden = Constants.TRUE;
		} else {
			self.detail_hidden = Constants.FALSE;
			self.content_hidden = Constants.TRUE;
		}
	}

	self.toggleContent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var content_shown = $('#module_tabs').hasClass('in');
		
		if(content_shown) {
			self.content_hidden = Constants.TRUE;
		} else {
			self.content_hidden = Constants.FALSE;
			self.detail_hidden = Constants.TRUE;

			if(!self.record.current_view) {
				self.setActiveContent(Constants.AGEGROUP)
			}
		}
	}

	self.setActiveContent = function(view) {
		self.record.current_view = view;
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

		self.searchDefaults();
		self.tableDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = [];

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageQuestionTempService.list(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.add = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};

		self.areas = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageQuestionTempService.add(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive();
					self.success = Constants.MSG_CREATED("Module");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	//operation type
	self.operationType = function(){

		 switch(self.record.operation){
			 // operations
			 default:
				 break;
		 }
	}

	self.actionButtons = function(variable){

		// scan whole text if there is an existing variable.
		// php scan strings with text combination.
		//

		//add case switch
		switch(variable){
			case Constants.NUMBER :
				//search on the text if {num[1-9]} exist
				//append to the next
				//add counter for number variable naming
				var variableName = self.actionVariableNames('num');
				self.record.question_template_format += variableName;
				self.record.question_equation += variableName;
				break;
			case Constants.OBJECT :
				// add counter object variable naming
				self.record.question_template_format += self.actionVariableNames('object');
				break;
			case Constants.NAME :
				//add counter for name variable naming
				self.record.question_template_format += self.actionVariableNames('name');
				break;
			case Constants.ADDITION :
				self.record.question_template_format += ' +';
				break;
			case Constants.SUBTRACTION :
				self.record.question_template_format += ' -';
				break;
			case Constants.DIVISION :
				self.record.question_template_format += ' /';
				break;
			case Constants.MULTIPLICATION :
				self.record.question_template_format += ' *';
				break;
			default:
				self.record.question_template_format += ' ';
				break;
		}
	}

	self.actionVariableNames = function(variableName){
		var i = 1;
		while(self.record.question_template_format.search('{' + variableName + i + '}') != -1){
			i++;
		}

		return ' {' + variableName + i + '}';
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionTempService.details(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					 self.record = response.data;
					 self.module_name = self.record.name;
					 self.record.area = (self.record.subjectarea) ? self.record.subjectarea.name : Constants.EMPTY_STR;
					 self.record.curriculum_country = self.curr_country_list = self.record.modulecountry;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};
		
		self.areas = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageQuestionTempService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
	    			self.success = Constants.MSG_UPDATED("Template");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;

		$("#delete_template_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteTemplate = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionTempService.deleteTemplate(self.record.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Template");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}


	//import to api data library
	self.importDataLibraryFile = function(file){

		var base_url = $("#base_url_form input[name='base_url']").val();

		if(file.length){
			$scope.ui_block();

			Upload.upload({
				url:'api/v1/data-library/import'
				, file: file[0]
				,headers: {
					'Content-Type': 'text/csv'
				}
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						console.log(response);
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}

	}

	//import to api word problem
	self.importWordProblemFile = function(file){

		var base_url = $("#base_url_form input[name='base_url']").val();

		if(file.length){
			$scope.ui_block();

			Upload.upload({
				url:'api/v1/word-problem-data/import'
				, file: file[0]
				,headers: {
					'Content-Type': 'text/csv'
				}
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						console.log(response);
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	//clear selected templates
	self.unSelectQuestionTemplate = function(){
		self.checkbox_value = false;
		self.checkbox_all = false;
	}

	self.addSelectedTemplates = function(module){
		var temp = [];
		angular.forEach(self.checkbox_value,function(value,key){
			temp.push(key);
		});

        ManageQuestionTempService.addModuleTemplates({ module_id : module.id, template : temp}).success(function(response){
            if(angular.equals(response.status,Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.getModuleTemplates(module);
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
	}

	self.getModuleTemplates = function(module){
		ManageQuestionTempService.getModuleTemplates(module.id).success(function(response){
            if(angular.equals(response.status,Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                	self.module_templates = response.data;
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
	}

	self.checkedTemplates = function(question_template_id,records){
		var is_checked = false;
		angular.forEach(records,function(value,key){
			if(question_template_id == value.question_template_id){
				is_checked = true;
			}
		});

		return is_checked;
	}

    self.generateDynamicQuestions = function(module_id){

        ManageQuestionTempService.generateDynamicQuestions(module_id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {

                    self.errors = $scope.errorHandler(response.errors);
                }
            }
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }


}
