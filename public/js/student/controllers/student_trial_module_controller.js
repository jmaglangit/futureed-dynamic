angular.module('futureed.controllers')
    .controller('StudentTrialModuleController', StudentTrialModuleController)
    .filter('range',  function() {
        return function(input, total) {
            total = parseInt(total);
            for (var i=0; i<total; i++)
                input.push(i);
            return input;
        };
    });

StudentTrialModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentTrialModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService) {
    var self = this;

    self.question_number = 0;
    self.answer = '';
    self.fib_answer = [];
    self.multi_array_answer = [];
    self.question_hide = false;
    self.show_correct = false;

    self.setActive = function(active, id) {
        self.errors = Constants.FALSE;

        self.active_questions = Constants.FALSE;
        self.active_contents = Constants.FALSE;
        self.result = Constants.FALSE;

        switch(active) {
            case Constants.ACTIVE_QUESTIONS 	:
                self.active_questions = Constants.TRUE;
                break;

            case Constants.ACTIVE_CONTENTS 	:

            default 		:
                self.active_contents = Constants.TRUE;
                break;
        }
    }

    /**
     * Retrieve Trial Module
     */
    self.retrieveTrialModule = function() {
        $scope.ui_block();
        StudentModuleService.getTrialModule().success(function(response) {
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else {
                    self.trialQuestion = response.data;
                    console.log(self.trialQuestion);
                }
            }
            $scope.ui_unblock();
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.checkAnswer = function() {
        self.errors = Constants.FALSE;
        var answer = {};

        answer.student_module_id = self.record.student_module.id;
        answer.module_id = self.record.id;
        answer.seq_no = self.current_question.seq_no;
        answer.question_id = self.current_question.id;
        answer.answer_id = self.current_question.answer_id;
        answer.student_id = $scope.user.id;
        answer.date_start = new Date();
        answer.date_end = new Date();

        if(angular.equals(self.current_question.question_type, Constants.ORDERING)) {
            answer.answer_text = self.current_question.answer_text.join(",");
        } else if(angular.equals(self.current_question.question_type, Constants.FILLINBLANK)) {
            var answer_text_array = [];

            angular.forEach(self.current_question.answer_text, function(value, key) {
                answer_text_array.push(value);
            });

            answer.answer_text = answer_text_array.join(",");
        } else if(angular.equals(self.current_question.question_type, Constants.GRAPH)) {

            var answer_graph_array = [];

            //Get horizontal
            if(self.question_graph_content.orientation == Constants.HORIZONTAL){

                //get table data
                //parse each value for horizontal values.
                var horizontalTable = document.getElementById('horizontalTable');

                answer_graph_array = self.horizontalGraph(horizontalTable);


                //Get Vertical
            }else if(self.question_graph_content.orientation == Constants.VERTICAL){

                //parse each value for vertical values
                var verticalTable = document.getElementById('verticalTable');

                answer_graph_array = self.verticalGraph(verticalTable);
            }

            obj = {"answer" : answer_graph_array};
            answer.answer_text = JSON.stringify(obj);
        } else if(angular.equals(self.current_question.question_type, Constants.QUADRANT)) {

            quadData = self.quad.getData();
            answer_quad_array = [];

            $.each(quadData[0].data, function(i,item){
                if(i > 0){
                    obj = {'x' : quadData[0].data[i][0], 'y' : quadData[0].data[i][1]}
                    answer_quad_array.push(obj);
                }
            });

            obj = {"answer" : answer_quad_array};
            answer.answer_text = JSON.stringify(obj);

        } else {
            answer.answer_text = self.current_question.answer_text;
        }

        $scope.ui_block();
        StudentModuleService.answerQuestion(answer).success(function(response) {
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                    self.result = {};

                    if(response.errors[0].error_code == 2056) {
                        self.result.failed = Constants.TRUE;
                    }

                    $scope.ui_unblock();
                } else if(response.data) {
                    // show message
                    self.result = response.data;
                    self.result.failed = Constants.FALSE;

                    if(angular.equals(self.result.module_status, "Completed")) {
                        // get points
                        var data = $scope.user;
                        data.points = parseInt(data.points) + parseInt(self.record.points_earned);

                        apiService.updateUserSession(data).success(function(response) {
                            $scope.getUserDetails();
                        });


                        var data = {};
                        data.age_group = 1;
                        data.module_id = self.record.id;
                        getPointsEarned(data, function(response) {
                            // save points
                            var data = {};
                            data.student_id = $scope.user.id;
                            data.points_earned = self.record.points_earned;
                            data.module_id = self.record.id;

                            saveStudentPoints(data, function(response) {
                                var avatar_id = $scope.user.avatar_id;

                                // get wiki
                                getWiki(avatar_id, function(response) {
                                    $scope.ui_unblock();

                                    var avatar_wiki = response.data[0];

                                    self.result = {};

                                    self.errors = Constants.FALSE;
                                    self.success = Constants.FALSE;

                                    self.module_message = {};
                                    self.module_message.points_earned = self.record.points_earned;
                                    self.module_message.show = Constants.TRUE;
                                    self.module_message.title = avatar_wiki.title;
                                    self.module_message.name = self.record.name;

                                    self.module_message.description_summary = avatar_wiki.description_summary;
                                    self.module_message.description_full = avatar_wiki.description_full;
                                    self.module_message.message = self.module_message.description_summary;

                                    self.module_message.image = avatar_wiki.image; // ok
                                    self.module_message.source = avatar_wiki.source;
                                    self.module_message.module_done = Constants.TRUE; // ok

                                    $("#message_modal").modal({
                                        backdrop: 'static',
                                        keyboard: Constants.FALSE,
                                        show    : Constants.TRUE
                                    });
                                });
                            });
                        });
                    } else if(angular.equals(self.result.module_status, "Failed")) {
                        self.result.failed = Constants.TRUE;
                        $scope.ui_unblock();
                    } else {
                        $scope.ui_unblock();

                        // update student_module
                        var data = {};
                        data.module_id = self.result.id;
                        data.last_answered_question_id = parseInt(self.result.next_question);

                        updateModuleStudent(data, function(response) {
                            setAvatarQuote();
                        });
                    }
                }
            }
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.validateAnswer = function() {
        $scope.ui_block();

        var data = {};

        data.question_number = self.question_number;
        data.question_type = self.trialQuestion[self.question_number]['type'];

        console.log("question_type: " + data.question_type + " fib_answer: " + self.fib_answer + " answer: " + self.answer);

        if(self.trialQuestion[self.question_number]['type'] == Constants.PROVIDE || self.trialQuestion[self.question_number]['type'] == Constants.MULTIPLECHOICE){
                data.answer = self.answer;
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.FILLINBLANK){
            data.answer = self.fib_answer;
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.GRAPH) {
            if(self.trialQuestion[self.question_number]['orientation'] === Constants.HORIZONTAL) {
                var horizontalTable = document.getElementById('horizontalTable');
                data.answer = self.horizontalGraph(horizontalTable);
            } else if(self.trialQuestion[self.question_number]['orientation'] === Constants.VERTICAL) {
                var verticalTable = document.getElementById('verticalTable');
                data.answer = self.verticalGraph(verticalTable);
            }
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.ORDERING) {
            data.answer = self.trialQuestion[self.question_number]['answer_string'];
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.QUADRANT) {
            quadData = self.quad.getData();
            answer_quad_array = [];

            $.each(quadData[0].data, function(i,item){
                if(i > 0){
                    obj = {'x' : quadData[0].data[i][0], 'y' : quadData[0].data[i][1]}
                    answer_quad_array.push(obj);
                }
            });

            data.answer = answer_quad_array;
        }
        console.log("\ndata.answer: " + data.answer);
        StudentModuleService.validateAnswer(data).success(function(response) {
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.fib_answer = [];
                    self.answer_valid = response.data.valid;
                    self.question_hide = true;
                    self.show_correct = true;
                    self.answer = '';

                    console.log(self.question_hide + ' ' + self.show_correct);
                }
            }
            $scope.ui_unblock();
        }).error(function(err) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.exitModule = function(redirect_to) {
            $window.location.href = redirect_to;
    }

    //parse horizontal table data.
    self.horizontalGraph = function(data){
        var graph_json = [];

        var y = data.rows.length;
        var header_count = data.rows.length;

        //horizontal headers
        for(h=0; h < header_count ; h++){

            header_data = {
                field : data.rows.item(h).cells.item(0).childNodes.item(1).className.replace("origin ",""),
                image :  data.rows.item(h).cells.item(0).childNodes.item(1).childNodes.item(1).attributes.item(1).nodeValue,
                count : 0,
                count_objects : 0
            };

            graph_json.push(header_data);
        }


        //parse the answers
        for(i=0; i < y ; i++){
            var cells = data.rows.item(i).cells;
            var x = cells.length;

            for(t=1; t < x ; t++){

                if(cells.item(t).firstElementChild !== null){

                    if(graph_json[i].field == cells.item(t).firstElementChild.className.replace("origin ","")){
                        graph_json[i].count = graph_json[i].count + 1;
                        graph_json[i].count_objects = graph_json[i].count_objects + 1;
                    }else {
                        graph_json[i].count_objects = graph_json[i].count_objects + 1;
                    }
                }
            }
        }

        return graph_json;
    }

    //parse vertical table data
    self.verticalGraph = function(data){

        var graph_json = [];
        var y = data.rows.length;

        //vertical headers
        var header_count = data.rows.item(0).cells.length;

        //get the headers
        for(h=0; h < header_count ; h++){
            header_data = {
                field : data.rows.item(0).cells.item(h).className,
                image : data.rows.item(0).cells.item(h).childNodes.item(1).childNodes.item(1).attributes.item(1).nodeValue,
                count : 0,
                count_objects : 0
            };

            graph_json.push(header_data);

        }

        //parse the answers
        for(i=1; i < y; i++){
            var cells = data.rows.item(i).cells;
            var x = cells.length;

            for(t=0; t < x; t++){

                if(cells.item(t).firstElementChild !== null){

                    if(graph_json[t].field == cells.item(t).firstElementChild.className.replace("origin ","")){
                        graph_json[t].count = graph_json[t].count + 1;
                        graph_json[t].count_objects = graph_json[t].count_objects + 1;
                    }else {
                        graph_json[t].count_objects = graph_json[t].count_objects + 1;
                    }
                }
            }
        }

        return graph_json;
    }

    var setAvatarQuote = function() {
        if(!((self.result.question_counter) % 5)) {
            // get quote
            var percentage = Math.floor((parseInt(self.result.correct_counter) / parseInt(self.result.question_counter)) * 100);
            var seq_no = Math.floor(parseInt(self.result.question_counter) / 5) % 6;
            var avatar_quote_sequence = (!seq_no) ? 6 : seq_no;

            var avatar_quote = self.avatar_quotes[avatar_quote_sequence];
            var avatar_quote_info = {};

            if(percentage < 20) {
                avatar_quote_info = avatar_quote[0];
            } else if(percentage >= 20 && percentage < 40) {
                avatar_quote_info = avatar_quote[20];
            } else if(percentage >= 40 && percentage < 60) {
                avatar_quote_info = avatar_quote[40];
            } else if(percentage >= 60 && percentage < 80) {
                avatar_quote_info = avatar_quote[60];
            } else if(percentage >= 80 && percentage < 100) {
                avatar_quote_info = avatar_quote[80];
            } else if(percentage >= 100) {
                avatar_quote_info = avatar_quote[100];
            } else {
                self.result.answered = Constants.TRUE;
            }

            // get pose
            var avatar_pose_id = avatar_quote_info.avatar_quote.avatar_pose_id;
            angular.forEach(self.avatar_pose, function(value, key) {
                if(angular.equals(parseInt(value.id), parseInt(avatar_pose_id))) {
                    avatar_quote_info.avatar_pose = value;
                    return;
                }
            });

            self.avatar_quote_info = avatar_quote_info;
            self.result.quoted = Constants.TRUE;
        } else {
            self.result.answered = Constants.TRUE;
        }

        self.result.points_earned = parseInt(self.result.points_earned);
    }

    self.selectAnswer = function(object) {
        self.answer = object.toString();
        console.log(self.answer);
    }

    self.nextQuestion = function() {
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;
        if(self.question_number != 10) {
            self.question_number++;
            self.question_hide = false;
            self.show_correct = false; //<---- Stuck here
        } else {
            self.trial_expired = true;
        }

    }

    self.updateBackground = function() {
        angular.element('body.student').css({
            'background-image' : 'url('+ $scope.user.background +')'
        });
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

    self.getGraph = function(question_id) {
        $scope.ui_block();
        StudentModuleService.getGraph(question_id).success(function(response) {

            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else {
                    self.graph_layout = [];

                    for(i = 0; i < response.data.dimension; i++){
                        self.graph_layout.push(i+1);
                    }

                    self.question_graph_content = JSON.parse(response.data.question_graph_content);
                }
            }

            $scope.ui_unblock();
        }).error(function(response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getQuadrant = function(){
        $scope.ui_block();
        console.log("X:"+self.trialQuestion[self.question_number]['coordinates'][0]+" Y:" +self.trialQuestion[self.question_number]['coordinates'][1]);
        //initialize plot data and options
        data = [[null]];
        options = {
            yaxis:  { min: -self.trialQuestion[self.question_number]['coordinates'][1], max: self.trialQuestion[self.question_number]['coordinates'][1], ticks: self.trialQuestion[self.question_number]['coordinates'][1] * 2},
            xaxis:  { min: -self.trialQuestion[self.question_number]['coordinates'][0], max: self.trialQuestion[self.question_number]['coordinates'][0], ticks: self.trialQuestion[self.question_number]['coordinates'][0] * 2},
            grid:   {clickable: true},
            points: { show: true, radius: 4, fill: true, fillColor: "#EDC240" }
        };

        //draw plot
        self.quad = $.plot($("#placeholder"), data, options);
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

        $scope.ui_unblock();

    }

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

                    if(angular.equals(self.trialQuestion[self.question_number]['orientation'], Constants.HORIZONTAL)) {
                        $(this).next().removeClass('disabled');
                    }else{
                        var cellIndex = $(this).index();
                        $(this).closest('tr').next().children().eq(cellIndex).removeClass('disabled');
                    }
                }
            }
        });
    }

    self.resetGraph = function () {
        if(angular.equals(self.trialQuestion[self.question_number]['type'], Constants.GRAPH)){
            $('.drop').removeClass('ui-droppable-disabled ui-state-disabled').addClass('disabled').empty().droppable('enable');
            $('td.first').removeClass('disabled');
        }else if(angular.equals(self.trialQuestion[self.question_number]['type'], Constants.QUADRANT)){
            data = [[null]];
            self.quad = $.plot($("#placeholder"), data, options);
        }
    }

    //function to compare arrays - used to evaluate quadrant plots
    self.arraysEqual = function(arr1, arr2) {
        if(arr1.length !== arr2.length)
            return false;

        for(var i = arr1.length; i--;) {
            if(arr1[i] !== arr2[i])
                return false;
        }

        return true;
    }
}