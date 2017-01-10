angular.module('futureed.controllers')
	.controller('ManageModuleController', ManageModuleController);

ManageModuleController.$inject = ['$scope', 'ManageModuleService', 'TableService', 'SearchService', 'Upload'];

function ManageModuleController($scope, ManageModuleService, TableService, SearchService, Upload) {
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
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_questions_preview = Constants.FALSE;
		self.question_preview_id = "#questions_preview";

		//self.tableDefaults();
		//self.searchDefaults();

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
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

			//TODO: transfer to a function should be outside setActive()
			case Constants.ACTIVE_QUESTIONS_PREVIEW :
				//self.tableDefaults();
				//self.searchDefaults();
				self.active_questions_preview = Constants.TRUE;
				self.module_table = self.table;
				self.details(id);
				self.getQuestions(id);
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
		ManageModuleService.list(self.search, self.table).success(function(response){
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
		ManageModuleService.add(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Module");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getSubject = function() {
		$scope.ui_block();
		ManageModuleService.getSubject().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.subjects = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setSubject = function() {
		self.record.subject_area_id = Constants.EMPTY_STR;
		self.record.area = Constants.EMPTY_STR;
		self.areas = Constants.FALSE;
	}

	self.searchArea = function() {
		self.validation = {};
		self.validation.s_loading = Constants.TRUE;

		ManageModuleService.searchArea(self.record.subject_id, self.record.area).success(function(response){
			self.validation.s_loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data) {
					if(response.data.records.length == 0) {
						if(area == ''){
							self.validation = {};
						}else{
							self.validation.s_error = ManageModuleConstants.NO_AREA;
						}
					}else {
						self.areas = response.data.records;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.selectArea = function(area) {
		self.record.subject_area_id = area.id;
		self.record.area = area.name;

		self.areas = Constants.FALSE;
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageModuleService.details(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.module_name = self.record.name;
					self.record.area = (self.record.subjectarea) ? self.record.subjectarea.name : Constants.EMPTY_STR;
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
		ManageModuleService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
	    			self.success = Constants.MSG_UPDATED("Module");
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

		$("#delete_module_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteModule = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageModuleService.deleteModule(self.record.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Module");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.upload = function(file, object) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
    	object.uploaded = Constants.FALSE;

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
                url: '/api/v1/module/icon'
                , file: file[0]
            }).success(function(response) {
                if(angular.equals(response.status, Constants.STATUS_OK)) {
	                if(response.errors) {
	                    self.errors = $scope.errorHandler(response.errors);
	                }else if(response.data){
                		object.image = response.data.image_name;
                		object.uploaded = Constants.TRUE;
                		self.image = object.image;
	                }
	            }

            	$scope.ui_unblock();
            }).error(function(response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
        }
	}

	self.viewImage = function(object) {
    	self.view_image = {};
		
		if(object.image) {
			self.view_image.image_path = "/uploads/temp/icon/" + object.image;
		} else if(object.icon_image) {
			self.view_image.image_path = object.icon_image;
		}

		self.view_image.teaching_module = (object.name) ? object.name : Constants.MODULE;
		self.view_image.show = Constants.TRUE;

		$("#view_image_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
    }

    self.removeImage = function(object) {
    	self.view_image = {};

    	object.image = Constants.EMPTY_STR;
    	object.image_path = Constants.EMPTY_STR;
    	object.uploaded = Constants.FALSE;
    }

	/* methods below for Module Preview */
    // get all questions by module id
    self.getQuestions = function(id) {
		self.errors = Constants.FALSE;
		self.question_list = [];

		self.table.size = Constants.FALSE;
		self.table.offset = Constants.FALSE;
		self.search.module_id = id;

		$scope.ui_block();
		ManageModuleService.questionList(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.question_list = response.data.records || Constants.FALSE;
					self.question_preview_ok = self.question_list.length > Constants.FALSE;
					self.question_index = 0;
					self.getQuestion(0);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//open question preview on modal
	self.openQuestionPreview = function(id){
		self.active_questions_preview = Constants.TRUE;
		self.module_table = self.table;
		self.details(id);
		self.getQuestions(id);
	}

	//close question preview
	self.closeQuestionPreview = function(){
		//close modal ang back to module lists

		self.active_questions_preview = Constants.FALSE;
		self.setActive(Constants.HIDE_MODULE);
	}

	// navigate question (previous/next) by index
	self.getQuestionByIndex = function(option = Constants.FALSE) {
		switch(option) {
			case Constants.NEXT:
				self.question_index = self.question_index < self.question_list.length ?
					parseInt(self.question_index) + 1 : self.question_index;
				break;

			case Constants.BACK:
				self.question_index = self.question_index > 0 ?
					parseInt(self.question_index) - 1 : self.question_index;
				break;

			default:
				break;
		}

		self.getQuestion(self.question_index || Constants.FALSE);
	}

	// get question by index from question_list
	self.getQuestion = function(index) {
		self.current_question = self.question_list[index] || Constants.FALSE;

		self.determineQuestionAnswer();
		self.getQuestionAnswerExplanations();
		self.question_number = parseInt(index) + 1;
		self.question_preview_end = index == self.question_list.length;

		$('#answer-explanations, #correct_graph, #quadrant').addClass('collapse').removeClass('in');
		$(self.question_preview_id).modal('show');
	}

	self.getQuestionAnswerExplanations = function() {
		if(self.current_question) {
			self.answer_explanations = [];

			var data = {
				module_id   : self.current_question.module_id,
				question_id : self.current_question.id,
				seq_no      : self.current_question.seq_no
			};

			ManageModuleService.getAnswerExplanation(data).success(function(response) {
				self.answer_explanations = response.data;
				self.answer_explanation_index = 0;
				self.getAnswerExplanation(0);
			}).error(function(response) {
				$scope.internalError(response);
			});
		}
	}

	self.getAnswerExplanationByIndex = function(option = Constants.FALSE) {
		switch(option) {
			case Constants.NEXT:
				self.answer_explanation_index = self.answer_explanation_index < self.answer_explanations.length ?
					parseInt(self.answer_explanation_index) + 1 : self.answer_explanation_index;
				break;

			case Constants.BACK:
				self.answer_explanation_index = self.answer_explanation_index > 0 ?
					parseInt(self.answer_explanation_index) - 1 : self.answer_explanation_index;
				break;

			default:
				break;
		}

		self.getAnswerExplanation(self.answer_explanation_index);
	}

	self.getAnswerExplanation = function(index) {
		self.answer_explanation = self.answer_explanations.records[index] || Constants.FALSE;
		self.answer_explanation_count = self.answer_explanation == Constants.FALSE ? Constants.FALSE : parseInt(index) + 1;
	}

	// prepares/computes question answer (depends on question_type)
	self.determineQuestionAnswer = function() {
		switch(self.current_question.question_type) {
			case Constants.FILLINBLANK:
				var input_fields = [];
				var field_count = parseInt(self.current_question.answer_text_field);

				for(var index = 0; index < field_count; index++) {
					input_fields.push(index);
				}

				self.current_question.answer_text_field_count = input_fields;
				self.current_question.question_answer = self.current_question.answer;
				break;

			case Constants.MULTIPLECHOICE:
				self.current_question.question_answer = self.current_question.question_answers.filter(function(q) {
					return q.correct_answer == Constants.YES;
				})[0] || Constants.FALSE;
				break;

			case Constants.ORDERING:
				self.answerTextOrderGenerator();
				self.current_question.question_answer = self.current_question.answer;
				break;

			case Constants.GRAPH:
				self.getGraph(self.current_question.id);
				break;

			case Constants.QUADRANT:
				self.getQuadrant(self.current_question.id);
				self.current_question.question_answer = JSON.parse(self.current_question.answer)
				break;

			default:
				self.current_question.question_answer = self.current_question.answer;
				break;
		}
	}

	self.dismissQuestionPreview = function() {
		self.current_question = Constants.FALSE;
		self.question_list = [];
		$(self.question_preview_id).modal('hide');
	}

	self.dragControlListeners = {
		accept: function (sourceItemHandleScope, destSortableScope) {
			return true;
	    }
	    , itemMoved: function (event) {

	    }
	    , orderChanged: function(event) {

	    }
	    , containment: '#board'//optional param.
	};

	self.initDrag = function (){
		$('.origin').draggable({
			containment: 'table',
			helper: 'clone',
			cursor: 'move',
			cursorAt: { left:-30 }
		});
	}

	self.initDrop = function (){
		$('.drop').droppable({
			accept: '.origin',
			drop: function(event, ui) {
				var thisClass = $(this).hasClass('disabled');

				if(thisClass){
					ui.draggable.draggable('option','revert',true);
				}else{
					$(this).append($(ui.draggable).clone());
					$(this).droppable('disable');
					ui.draggable.draggable('option','revert','invalid');

					if(angular.equals(self.question_graph_content.orientation, Constants.HORIZONTAL)) {
						$(this).next().removeClass('disabled');
					}else{
						var cellIndex = $(this).index();
						$(this).closest('tr').next().children().eq(cellIndex).removeClass('disabled');
					}
				}
			}
		});
	}

	// ordering parse strings into object (question type : ORDERING)
	self.answerTextOrderGenerator = function(){
		self.order_items = self.current_question.question_order_text.split(",");

		var answer_text = [];
		angular.forEach(self.order_items,function(v,i){
			var object = {
				value : v,
				key : i
			};
			answer_text.push(object);
		});
		self.current_question.answer_text = answer_text;
	}

	// get graph for displaying question (type : GRAPH)
	self.getGraph = function(question_id) {
		$scope.ui_block();
		ManageModuleService.getGraph(question_id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					self.graph_layout = [];

					for(i = 0; i < response.data.dimension; i++){
						self.graph_layout.push(i+1);
					}

					self.question_graph_content = JSON.parse(response.data.question_graph_content);

					var answers = JSON.parse(self.current_question.answer).answer;
					self.getGraphAnswer(answers,  self.graph_layout);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	// compute horizontal/vertical graph answer to generate correct graph answer
	self.getGraphAnswer = function(answers, graph_layout) {
		var result = [];

		$.each(answers, function(index, answer) {
			result[index] = [];
			result[index].lack_tds = Array.apply(null, Array(graph_layout.length - parseInt(answer.count) || Constants.FALSE))
				.map(function (x, o) { return o; });

			for(var i = 0; i < parseInt(answer.count); i++) {
				result[index][i] = {
					field : answer.field,
					image : answer.image
				};
			}
		});

		// compute vertical graph answer for generating
		if(self.question_graph_content.orientation == Constants.VERTICAL) {
			var temp_result = [];

			$.each(result, function(index, row) {
				var tmp_rows = [];

				$.each(row, function(key, val) {
					tmp_rows[key] = val;
				});

				tmp_rows = tmp_rows.concat(row.lack_tds);
				temp_result.push(tmp_rows);
			});

			result = [];
			for(var i = 0; i < graph_layout.length; i++) {
				result[i] = [];
				for(var x = 0; x < temp_result.length; x++) {
					if(!isNaN(temp_result[x][i])) {
						temp_result[x][i] = { num : temp_result[x][i], isNumber : true }
					} else {
						temp_result[x][i].isNumber =  false;
					}
					result[i].push(temp_result[x][i]);
				}
			}
		}

		self.current_question.question_answer = result;
	}

	// get quadrant for diplaying question (type: QUADRANT)
	self.getQuadrant = function(question_id){
		$scope.ui_block();
		ManageModuleService.getGraph(question_id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else {
					//initialize plot data and options
					data = [[null]];
					options = {
						yaxis: { min: -response.data.dimension, max: response.data.dimension, ticks: response.data.dimension * 2},
						xaxis: { min: -response.data.dimension, max: response.data.dimension, ticks: response.data.dimension * 2},
						grid: {clickable: true},
						points: { show: true, radius: 4, fill: true, fillColor: "#EDC240" }
					};

					//draw plot
					self.quad = $.plot($("#placeholder"), data, options)
					$("#placeholder").bind("plotclick", function (event, pos, item) {

						if(!item){
							newData = self.quad.getData();

							//check for duplicates
							$.each(newData[0].data, function(i,item){
								var arr1 = newData[0].data[i];
								var arr2 = [Math.round(pos.x),Math.round(pos.y)];

								if(newData[0].data[i] != null){
									duplicate_point = self.arraysEqual(arr1,arr2);
									if(duplicate_point){
										return false;
									}
								}else{
									duplicate_point = false;
								}
							});

							if(!duplicate_point){
								newData[0].data.push([Math.round(pos.x),Math.round(pos.y)]);
								self.quad.setData(newData);
								self.quad.setupGrid();
								self.quad.draw();
							}
						}
					});

					self.setQuadrantAnswer(options);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	// compute quadrant answer (generate quadrant with correct plotted points)
	self.setQuadrantAnswer = function(options) {
		var answers = [];

		$.each(self.current_question.question_answer.answer, function(key, val) {
			answers[key] = [ val.x, val.y ];
		});

		var data = [
			{ data: answers }
		];

		$.plot($("#quadrant-answer"), data, options);
	}

	// function to compare arrays - used to evaluate quadrant plots
	self.arraysEqual = function(arr1, arr2) {
		if(arr1.length !== arr2.length) {
			return false;
		}

		for(var i = arr1.length; i--;) {
			if(arr1[i] !== arr2[i]) {
				return false;
			}
		}

		return true;
	}

	self.resetGraph = function () {
		if(angular.equals(self.current_question.question_type, Constants.GRAPH)){
			$('.drop').removeClass('ui-droppable-disabled ui-state-disabled').addClass('disabled').empty().droppable('enable');
			$('td.first').removeClass('disabled');
		}else if(angular.equals(self.current_question.question_type, Constants.QUADRANT)){
			data = [[null]];
			self.quad = $.plot($("#placeholder"), data, options);
		}
	}
}

//TODO: cause of restarting module.
// handle on hide/dismiss question preview (triggered when modal is closed)
//$(document).on('hidden.bs.modal', '#questions_preview', function () {
//	refreshModuleList();
//});

// call module set active - to default list view
//function refreshModuleList() {
//	var scope = angular.element($('#module-cont')).scope();
//    scope.$apply(function () {
//		scope.module.setActive();
//    });
//}
