angular.module('futureed.controllers')
    .controller('ManageModuleQuestionController', ManageModuleQuestionController);

ManageModuleQuestionController.$inject = ['$scope', 'ManageModuleQuestionService', 'TableService', 'SearchService'];

function ManageModuleQuestionController($scope, ManageModuleQuestionService, TableService, SearchService) {
    var self = this;

    TableService(self);
    self.tableDefaults();

    SearchService(self);
    self.searchDefaults();

    self.setActive = function(active, id){
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;

        self.validation = {};
        self.record = {};
        self.fields = [];

        self.question_no_preview = Constants.FALSE;
        self.active_questions_preview = Constants.FALSE;

        self.tableDefaults();
        self.searchDefaults();

        switch(active) {
            default:
                //get questions by module
                self.active_questions_preview = Constants.TRUE;
                self.details(id);
                self.getQuestions(id);
                break;
        }
    }

    self.getQuestions = function(id) {
        self.errors = Constants.FALSE;
        self.question_list = [];

        self.table.size = Constants.FALSE;
        self.table.offset = Constants.FALSE;
        self.search.module_id = id;
        self.search.status = Constants.ENABLED;

        $scope.ui_block();
        ManageModuleQuestionService.questionList(self.search, self.table).success(function(response){
            self.table.loading = Constants.FALSE;
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    self.question_list = response.data.records || Constants.FALSE;
                    self.getQuestion(0);
                    self.question_preview_ok = self.question_list.length > Constants.FALSE;
                    self.question_index = 0;

                    if(response.data.total == Constants.FALSE){
                        self.question_no_preview = Constants.TRUE;
                        $scope.ui_unblock();
                    }
                }else {
                    self.question_no_preview = Constants.TRUE;
                    $scope.ui_unblock();
                }
            }
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    // get question by index from question_list
    self.getQuestion = function(index) {
        $scope.ui_block();
        self.current_question = self.question_list[index] || Constants.FALSE;

        self.determineQuestionAnswer();

        self.question_number = parseInt(index) + 1;
        self.question_preview_end = index == self.question_list.length;

        if(self.question_preview_end && self.question_preview_ok){
            $scope.ui_unblock();
        }

        $('#answer-explanations, #correct_graph, #quadrant').addClass('collapse').removeClass('in');
        $(self.question_preview_id).modal('show');
    }

    // prepares/computes question answer (depends on question_type)
    self.determineQuestionAnswer = function() {
        $scope.ui_block();
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
        self.getQuestionAnswerExplanations();
    }

    // ordering parse strings into object (question type : ORDERING)
    self.answerTextOrderGenerator = function(){
        $scope.ui_block();
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
        ManageModuleQuestionService.getGraph(question_id).success(function(response) {

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

    self.getQuestionAnswerExplanations = function() {
        $scope.ui_block();
        if(self.current_question) {
            self.answer_explanations = [];

            var data = {
                module_id   : self.current_question.module_id,
                question_id : self.current_question.id,
                seq_no      : self.current_question.seq_no
            };

            ManageModuleQuestionService.getAnswerExplanation(data).success(function(response) {
                self.answer_explanations = response.data;
                self.answer_explanation_index = 0;
                self.getAnswerExplanation(0);
                $scope.ui_unblock();
            }).error(function(response) {
                $scope.internalError(response);
            });
        }
    }

    self.getAnswerExplanation = function(index) {
        self.answer_explanation = self.answer_explanations.records[index] || Constants.FALSE;
        self.answer_explanation_count = self.answer_explanation == Constants.FALSE ? Constants.FALSE : parseInt(index) + 1;
    }

    // get quadrant for diplaying question (type: QUADRANT)
    self.getQuadrant = function(question_id){
        $scope.ui_block();
        ManageModuleQuestionService.getGraph(question_id).success(function(response) {

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

        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.details = function(id) {
        self.errors = Constants.FALSE;

        $scope.ui_block();
        ManageModuleQuestionService.details(id).success(function(response){
            if(angular.equals(response.status,Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.record = response.data;
                    self.module_name = self.record.name;
                    self.record.area = (self.record.subjectarea) ? self.record.subjectarea.name : Constants.EMPTY_STR;
                }
            }
        }).error(function(response) {
            self.errors = internalError();
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

    // navigate question (previous/next) by index
    self.getQuestionByIndex = function(option = Constants.FALSE) {

        //clear answer explanation
        self.answer_explanation = Constants.FALSE;

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

    self.parseJSONAnswer = function(answer_json){

        var answer_object = JSON.parse(answer_json);

        var answers = '';

        angular.forEach(answer_object.answer,function(value,key){
            if(key > Constants.FALSE) {
                answers += ',' + value.value;
            } else {
                answers = value.value;
            }

        });

        return answers;
    }
}