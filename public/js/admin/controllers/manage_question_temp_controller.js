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
		self.question_text = '';

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

        self.record.question_template_format += self.actionVariableNames(variable);
        self.record.question_template_format += ' ';
        $('button[name=btn_' + variable + ']').prop('disabled', true);
		$('#template_text').focus();

	}

	self.validateTemplateText = function(){

        var tempTextArea = document.getElementById('template_text');
        tempTextArea.onkeyup = function() {
            var val = tempTextArea.value;

            //addition variables
            if ((val.indexOf("{addends1}")) == Constants.NEGATIVE_1) {
                $('button[name=btn_addends_one]').prop('disabled', false);
            } else {
                $('button[name=btn_addends_one]').prop('disabled', true);
            }
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
			'question_template_format' : self.record.question_template_format,
			'operation' : self.record.operation,
			'question_form' : self.record.question_form
		};

		self.dynamicQuestionSetup(data);

        $("#preview_question").modal({
                            backdrop: 'static',
                            keyboard: Constants.FALSE,
                            show    : Constants.TRUE
		});
	}

	self.getQuestionTemplateOperations = function(){

    	var data = {};

    	ManageQuestionTempService.getQuestionTemplateOperations(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else {
                    self.question_template_operation = response.data.records;
                }
            }
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });

	}

    self.dynamicQuestionSetup = function(question){

        var question_text = question.question_template_format;

        console.log('question here --' + question_text);

        //check type of operation
        switch(question.operation){
            case Constants.ADDITION:

				randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.ADDENDS1 + '}',getRandomNumber1());
                question_text = question_text.replace('{' + Constants.ADDENDS2 + '}',getRandomNumber2());
                break;

            case Constants.SUBTRACTION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.MINUEND + '}', getRandomNumber1());
                question_text = question_text.replace('{' + Constants.SUBTRAHEND +'}', getRandomNumber2());
                break;

            case Constants.MULTIPLICATION:

            	randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.MULTIPLIER + '}',getRandomNumber2());
                question_text = question_text.replace('{' + Constants.MULTIPLICAND + '}',getRandomNumber1());
                break;

            case Constants.DIVISION:

				randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DIVIDEND + '}',getRandomNumber2());
                question_text = question_text.replace('{' + Constants.DIVISOR + '}',getRandomNumber1());
                break;

            case Constants.FRACTION_DIVISION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_DIVISION + '}', "");
                break;

            case Constants.FRACTION_ADDITION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_ADDITION + '}', "");
                break;

            case Constants.FRACTION_SUBTRACTION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_SUBTRACTION + '}', "");
                break;

            case Constants.FRACTION_SUBTRACTION_BUTTERFLY:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_SUBTRACTION_BUTTERFLY + '}',"");
                break;

            case Constants.FRACTION_MULTIPLICATION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_MULTIPLICATION + '}', "");
                break;

            case Constants.FRACTION_ADDITION_WHOLE:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_ADDITION_WHOLE + '}',"");
                break;

            case Constants.FRACTION_ADDITION_BUTTERFLY:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_ADDITION_BUTTERFLY + '}', "");
				break;

            case Constants.FRACTION_SUBTRACTION_WHOLE:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_SUBTRACTION_WHOLE + '}',"");
                break;

            case Constants.INTEGER_ADDITION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_ADDITION + '}',"");
				break;

            case Constants.INTEGER_CONVERT_NUMBER:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_CONVERT_NUMBER + '}',getRandomNumber1());
                console.log('question text --' + question_text);
                break;

			case Constants.INTEGER_COUNTING:

				randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_COUNTING + '}',getRandomNumber1());
				break;

            case Constants.INTEGER_DECIMAL:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_DECIMAL + '}',getRandomNumber1() + '.' + getRandomNumber2());
                break;

            case Constants.INTEGER_EXPANDED_DECIMAL:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_EXPANDED_DECIMAL + '}',getRealNumber());
                break;

            case Constants.INTEGER_EXTENDED:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_EXTENDED + '}',getRealNumber());
				break;

			case Constants.INTEGER_IDENTIFY:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_RANDOM_DIGIT + '}',getDigitsNumber());
                question_text = question_text.replace('{' + Constants.INTEGER_RANDOM_NUMBER + '}',getRandomNumber());
				break;

            case Constants.INTEGER_REGROUP:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.NUMBER1 + '}', getFirstNumber() + ' ' + getFirstNumberWords());
                question_text = question_text.replace('{' + Constants.NUMBER2 + '}', getSecondNumber() + ' ' + getSecondNumberWords());
                break;

            case Constants.INTEGER_ROUNDING_NUMBER:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_RANDOM_NUMBER + '}',getRandomNumber());
                question_text = question_text.replace('{' + Constants.INTEGER_RANDOM_WORD + '}',getRandomWords());
                break;

            case Constants.INTEGER_SORT_LARGE:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_SORT_LARGE +'}',getRandomNumber1());
                break;

            case Constants.INTEGER_SORT_SMALL:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.INTEGER_SORT_SMALL + '}',getRandomNumber1());
                break;

            case Constants.DECIMAL_ADDITION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_ADDENDS1 + '}',getRandomNumber1());
                question_text = question_text.replace('{' + Constants.DECIMAL_ADDENDS2 + '}',getRandomNumber2());
                break;

            case Constants.DECIMAL_COMPARE:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_RANDOM_NUMBER1 + '}', getFirstNumber() + '.' + getFirstDecimalDigit());
                question_text = question_text.replace('{' + Constants.DECIMAL_RANDOM_NUMBER2 + '}', getSecondNumber() + '.' + getSecondDecimalDigit());
                break;

			case Constants.DECIMAL_NUMERIC:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_RANDOM_WORD + '}', getCorrectAnswer());
				break;

            case Constants.DECIMAL_UNDERSTAND:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_RANDOM_DIGIT + '}',getDigitsNumber());
                question_text = question_text.replace('{' + Constants.DECIMAL_RANDOM_NUMBER + '}', getFirstDecimalDigit() + '' + getSecondDecimalDigit());
                break;

            case Constants.FRACTION_DECIMAL:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.FRACTION_DECIMAL_NUMERATOR + '}',getDigitNumerator());
                question_text = question_text.replace('{' + Constants.FRACTION_DECIMAL_DENOMINATOR + '}', getDigitDenominator());
                break;

            case Constants.DECIMAL_FRACTION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_FRACTION + '}',getInteger() + '.' + getDecimal());
                break;

            case Constants.DECIMAL_WORDS:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_WORDS + '}',getFirstNumber() + getSecondNumber());
                break;

            case Constants.DECIMAL_SUBTRACTION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_MINUEND + '}',getRandomNumber1());
                question_text = question_text.replace('{' + Constants.DECIMAL_SUBTRAHEND + '}',getRandomNumber2());
                break;

            case Constants.DECIMAL_RATIONAL_NUMBER:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_RATIONAL_NUMBER + '}', "");
                break;

            case Constants.DECIMAL_DIVISION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_DIVIDEND + '}',getRandomNumber1());
                question_text = question_text.replace('{' + Constants.DECIMAL_DIVISOR + '}',getRandomNumber2());
                break;

            case Constants.DECIMAL_MULTIPLICATION:

                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.DECIMAL_MULTIPLICAND + '}',getRandomNumber1());
                question_text = question_text.replace('{' + Constants.DECIMAL_MULTIPLIER + '}',getRandomNumber2());
                break;

            case Constants.EXPONENT:
                randomDigitsOnclick();
                question_text = question_text.replace('{' + Constants.EXPONENT + '}', "");
                break;

            default:
                break;
        }

        self.question_text = question_text;
    }



}
