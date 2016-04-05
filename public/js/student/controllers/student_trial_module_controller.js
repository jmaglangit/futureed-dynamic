angular.module('futureed.controllers')
    .controller('StudentTrialModuleController', StudentTrialModuleController);

StudentTrialModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentTrialModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService) {
    var self = this;

    self.question_number = 0;
    self.answer = '';
    self.fib_answer = [];
    self.multi_array_answer = [];
    self.question_hide = Constants.FALSE;
    self.show_correct = Constants.FALSE;

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
                }
            }
            $scope.ui_unblock();
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

        if(self.trialQuestion[self.question_number]['type'] == Constants.PROVIDE || self.trialQuestion[self.question_number]['type'] == Constants.MULTIPLECHOICE){
                data.answer = self.answer;
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.FILLINBLANK){
            data.answer = self.fib_answer;
            data.fib_length = self.trialQuestion[self.question_number]['number_of_blanks'];
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
            data.answer = self.trialQuestion[self.question_number]['unordered_list'].join();
        }
        else if(self.trialQuestion[self.question_number]['type'] == Constants.QUADRANT) {
            quadData = self.quad.getData();
            answer_quad_array = {};

            $.each(quadData[0].data, function(i,item){
                if(i > 0){
                    obj = {'x' : quadData[0].data[i][0], 'y' : quadData[0].data[i][1]}
                    answer_quad_array.answer = [obj];
                }
                data.has_plotted = i;
            });

            data.answer =  JSON.stringify(answer_quad_array);
        }
        StudentModuleService.validateAnswer(data).success(function(response) {
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.fib_answer = [];
                    self.answer_valid = response.data.valid;
                    self.question_hide = Constants.TRUE;
                    self.show_correct = Constants.TRUE;
                    self.answer = '';
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

            graph_json.push(0);
        }


        //parse the answers
        for(i=0; i < y ; i++){
            var cells = data.rows.item(i).cells;
            var x = cells.length;

            for(t=1; t < x ; t++){

                if(cells.item(t).firstElementChild !== null){

                    if(graph_json[i].field == cells.item(t).firstElementChild.className.replace("origin ","")){
                        graph_json[i] += 1;
                    }else {
                        graph_json[i] +=1;
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


            graph_json.push(0);

        }

        //parse the answers
        for(i=1; i < y; i++){
            var cells = data.rows.item(i).cells;
            var x = cells.length;

            for(t=0; t < x; t++){

                if(cells.item(t).firstElementChild !== null){

                    if(graph_json[t].field == cells.item(t).firstElementChild.className.replace("origin ","")){
                        graph_json[t] += 1;
                    }else {
                        graph_json[t] += 1;
                    }
                }
            }
        }

        return graph_json;
    }

    self.selectAnswer = function(object) {
        self.answer = [
            self.trialQuestion[self.question_number]['choices_list'][object]['image_choice'],
            self.trialQuestion[self.question_number]['choices_list'][object]['string_choice']
        ];
    }

    self.nextQuestion = function() {
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;
        if(self.question_number != 9) {
            self.question_number++;
            self.question_hide = Constants.FALSE;
            self.show_correct = Constants.FALSE;
        } else {
            self.show_correct = Constants.FALSE;
            self.trial_expired = Constants.TRUE;
        }
        self.trialQuestion
    }

    self.updateBackground = function() {
        angular.element('body.student').css({
            'background-image' : 'url('+ $scope.user.background +')'
        });
    }

    self.dragControlListeners = {
        accept: function (sourceItemHandleScope, destSortableScope) {
            return Constants.TRUE;
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
        //initialize plot data and options
        data = [[null]];
        var quadrant = self.trialQuestion[self.question_number]['dimension'];

        options = {
            yaxis:  { min: -quadrant.y, max: quadrant.y, ticks: quadrant.y * 2},
            xaxis:  { min: -quadrant.x, max: quadrant.x, ticks: quadrant.x * 2},
            grid:   { clickable: Constants.TRUE},
            points: { show: Constants.TRUE, radius: 4, fill: Constants.TRUE, fillColor: "#EDC240" }
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
                            return Constants.FALSE;
                        }
                    }else{
                        duplicate_point = Constants.FALSE;
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
                    ui.draggable.draggable('option','revert',Constants.TRUE);
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
            return Constants.FALSE;

        for(var i = arr1.length; i--;) {
            if(arr1[i] !== arr2[i])
                return Constants.FALSE;
        }

        return Constants.TRUE;
    }
}