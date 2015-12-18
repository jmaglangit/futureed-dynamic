angular.module('futureed.services')
    .factory('ManageQuestionAnsService', ManageQuestionAnsService);

ManageQuestionAnsService.$inject = ['$http'];

function ManageQuestionAnsService($http) {
    var api = {};
    var apiUrl = '/api/v1/';

    api.list = function(search, table) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/admin?module_id=' + search.module_id
                + '&question_type=' + search.question_type
                + '&questions_text=' + search.questions_text
                + '&limit=' + table.size
                + '&offset=' + table.offset
        });
    }

    api.add = function(data) {
        return $http({
            method  : Constants.METHOD_POST
            , data  : data
            , url   : apiUrl + 'question/admin'
        });
    }

    api.details = function(id) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/admin/' + id
        });
    }

    api.update = function(data) {
        return $http({
            method  : Constants.METHOD_PUT
            , data  : data
            , url   : apiUrl + 'question/admin/' + data.id
        });
    }

    api.deleteQuestion = function(id) {
        return $http({
            method  : Constants.METHOD_DELETE
            , url   : apiUrl + 'question/admin/' + id
        });
    }

    api.addAnswer = function(data) {
        return $http({
            method  : Constants.METHOD_POST
            , data  : data
            , url   : apiUrl + 'question/answer/admin'
        });
    }

    api.addAnswerGraph = function(question_id, data) {
        return $http({
           method  : Constants.METHOD_POST
            , data  : data
            , url   : apiUrl + 'question/graph-answer/admin/' + question_id 
        });
    }

    api.listAnswer = function(question_id) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/answer/admin?question_id=' + question_id
        });
    }

    api.deleteAnswer = function(id) {
        return $http({
            method  : Constants.METHOD_DELETE
            , url   : apiUrl + 'question/answer/admin/' + id
        });
    }

    api.answerDetails = function(id) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/answer/admin/' + id
        });
    }

    api.updateAnswer = function(data) {
        return $http({
            method  : Constants.METHOD_PUT
            , data  : data
            , url   : apiUrl + 'question/answer/admin/' + data.id
        });
    }

    return api;
}