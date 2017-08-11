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
					self.success = Constants.MSG_CREATED("Question template");
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
		self.isClicked = Constants.TRUE;
		self.record.question_template_format = '';

		 switch(self.record.operation){
			 // operations
			 default:
				 break;
		 }
	}

	self.actionButtons = function(variable){

		// scan whole text if there is an existing variable.
		// php scan strings with text combination.
		// disable button once clicked.

		//add case switch
		switch(variable){
			case Constants.ADDENDS1 :
				self.record.question_template_format += self.actionVariableNames('addends1');
			    $('button[name=btn_addends_one]').prop('disabled', true);
				break;
			case Constants.ADDENDS2 :
				self.record.question_template_format += self.actionVariableNames('addends2');
			    $('button[name=btn_addends_two]').prop('disabled', true);
				break;
			case Constants.MINUEND :
				self.record.question_template_format += self.actionVariableNames('minuend');
			    $('button[name=btn_minuend]').prop('disabled', true);
				break;
			case Constants.SUBTRAHEND :
				self.record.question_template_format += self.actionVariableNames('subtrahend');
			    $('button[name=btn_subtrahend]').prop('disabled', true);
				break;
			case Constants.MULTIPLICAND :
				self.record.question_template_format += self.actionVariableNames('multiplicand');
			    $('button[name=btn_multiplicand]').prop('disabled', true);
				break;
			case Constants.MULTIPLIER :
				self.record.question_template_format += self.actionVariableNames('multiplier');
			    $('button[name=btn_multiplier]').prop('disabled', true);
				break;
			case Constants.DIVIDEND :
				self.record.question_template_format += self.actionVariableNames('dividend');
			    $('button[name=btn_dividend]').prop('disabled', true);
				break;
			case Constants.DIVISOR :
				self.record.question_template_format += self.actionVariableNames('divisor');
			    $('button[name=btn_divisor]').prop('disabled', true);
				break;
			case Constants.FRACTION_ADDITION :
				self.record.question_template_format += self.actionVariableNames('fraction_addition');
			    $('button[name=btn_fraction_addition]').prop('disabled', true);
				break;
			case Constants.FRACTION_SUBTRACTION :
				self.record.question_template_format += self.actionVariableNames('fraction_subtraction');
			    $('button[name=btn_fraction_subtraction]').prop('disabled', true);
				break;
			case Constants.FRACTION_MULTIPLICATION :
				self.record.question_template_format += self.actionVariableNames('fraction_multiplication');
			    $('button[name=btn_fraction_multiplication]').prop('disabled', true);
				break;
			case Constants.FRACTION_DIVISION :
				self.record.question_template_format += self.actionVariableNames('fraction_division');
			    $('button[name=btn_fraction_division]').prop('disabled', true);
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

		return ' {' + variableName + '}';
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;
		self.isClicked = Constants.FALSE;

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

	self.validateTemplateText = function(){
		var tempTextArea = document.getElementById('template_text');

		//enable/disable variables button
		tempTextArea.onkeyup = function(){
			var val = tempTextArea.value;

			//addition variables
			if((val.indexOf("{addends1}")) == Constants.NEGATIVE_1){
				$('button[name=btn_addends_one]').prop('disabled', false);
			}else{$('button[name=btn_addends_one]').prop('disabled', true);}

			if((val.indexOf("{addends2}")) == Constants.NEGATIVE_1){
				$('button[name=btn_addends_two]').prop('disabled', false);
			}else{$('button[name=btn_addends_two]').prop('disabled', true);}

			//subtraction variables
			if(val.indexOf("{minuend}") == Constants.NEGATIVE_1){
				$('button[name=btn_minuend]').prop('disabled', false);
			}else{ $('button[name=btn_minuend]').prop('disabled', true);}

			if(val.indexOf("{subtrahend}") == Constants.NEGATIVE_1){
				$('button[name=btn_subtrahend]').prop('disabled', false);
			}else{$('button[name=btn_subtrahend]').prop('disabled', true);}

			//multiplication variables
			if(val.indexOf("{multiplicand}") == Constants.NEGATIVE_1){
				$('button[name=btn_multiplicand]').prop('disabled', false);
			}else{$('button[name=btn_multiplicand]').prop('disabled', true);}

			if(val.indexOf("{multiplier}") == Constants.NEGATIVE_1){
				$('button[name=btn_multiplier]').prop('disabled', false);
			}else{$('button[name=btn_multiplier]').prop('disabled', true);}

			//division variables
			if(val.indexOf("{dividend}") == Constants.NEGATIVE_1){
				$('button[name=btn_dividend]').prop('disabled', false);
			}else{$('button[name=btn_dividend]').prop('disabled', true);}

			if(val.indexOf("{divisor}") == Constants.NEGATIVE_1){
				$('button[name=btn_divisor]').prop('disabled', false);
			}else{$('button[name=btn_divisor]').prop('disabled', true);}

			//fraction variables
			if(val.indexOf("{fraction_addition}") == Constants.NEGATIVE_1){
				$('button[name=btn_fraction_addition]').prop('disabled', false);
			}else{$('button[name=btn_fraction_addition]').prop('disabled', true);}

			if(val.indexOf("{fraction_subtraction}") == Constants.NEGATIVE_1){
				$('button[name=btn_fraction_subtraction]').prop('disabled', false);
			}else{$('button[name=btn_fraction_subtraction]').prop('disabled', true);}

			if(val.indexOf("{fraction_multiplication}") == Constants.NEGATIVE_1){
				$('button[name=btn_fraction_multiplication]').prop('disabled', false);
			}else{$('button[name=btn_fraction_multiplication]').prop('disabled', true);}

			if(val.indexOf("{fraction_division}") == Constants.NEGATIVE_1){
				$('button[name=btn_fraction_division]').prop('disabled', false);
			}else{$('button[name=btn_fraction_division]').prop('disabled', true);}
		}
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
                    self.success = Constants.MSG_UPDATED("Template list");

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
                } else {
                    self.success = Constants.MSG_CREATED("Questions");
				}
            }
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.questionPreview = function(){

    	//get preview constants
		var data = {
			'question_template_format' : encodeURIComponent(self.record.question_template_format),
			'operation' : self.record.operation,
			'question_form' : self.record.question_form
		};

    	ManageQuestionTempService.questionPreview(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else {
                    self.question_preview = response.data;
                    //pop-up modal and display questions

                    $("#preview_question").modal({
                        backdrop: 'static',
                        keyboard: Constants.FALSE,
                        show    : Constants.TRUE
                    });
                }
            }
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
	}

}
