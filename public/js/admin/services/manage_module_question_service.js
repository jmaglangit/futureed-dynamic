angular.module('futureed.services')
    .factory('ManageModuleQuestionService', ManageModuleQuestionService);

ManageModuleQuestionService.$inject = ['$http'];

function ManageModuleQuestionService($http) {
    var api = {};
    var apiUrl = '/api/v1/';

    //get questions by module_id
    api.questionList = function(search, table) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/admin?module_id=' + search.module_id
            + '&question_type=' + search.question_type
            + '&questions_text=' + search.questions_text
            + '&status=' + search.status
            + '&limit=' + table.size
            + '&offset=' + table.offset
        });
    }

    api.details  = function(id) {
        return $http({
            method 	: Constants.METHOD_GET
            , url 	: apiUrl + 'module/admin/' + id
        });
    }

    api.getGraph = function(question_id) {
        return $http({
            method 	: Constants.METHOD_GET,
            url     : apiUrl + 'student/question/graph/' + question_id
        });
    }

    api.getAnswerExplanation = function(data){
        return $http({
            method	:	Constants.METHOD_GET,
            url	    :	apiUrl + 'answer-explanation?'
            +	'module_id=' +	data.module_id
            +	'&question_id='	+	data.question_id
            +	'&seq_no='	+	data.seq_no
        });
    }




    return api;
}