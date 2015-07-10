angular.module('futureed.services')
    .factory('ManageQuestionAnsService', ManageQuestionAnsService);

ManageQuestionAnsService.$inject = ['$http'];

function ManageQuestionAnsService($http) {
    var qaServiceApi = {};
    var qaServiceUrl = '/api/v1/';

    qaServiceApi.list = function(id, search, table) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : qaServiceUrl + 'question/admin?module_id=' + id
                + '&question_type=' + search.question_type
                + '&questions_text=' + search.questions_text
                + '&limit=' + table.size
                + '&offset=' + table.offset
        });
    }

    qaServiceApi.addNewQuestion = function(data) {
        return $http({
            method  : Constants.METHOD_POST
            , data  : data
            , url   : qaServiceUrl + 'question/admin'
        });
    }

    qaServiceApi.getQuestionDetail = function(id) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : qaServiceUrl + 'question/admin/' + id
        });
    }

    qaServiceApi.saveEditQuestion = function(data) {
        return $http({
            method  : Constants.METHOD_PUT
            , data  : data
            , url   : qaServiceUrl + 'question/admin/' + data.id
        });
    }

    qaServiceApi.deleteQuestion = function(id) {
        return $http({
            method  : Constants.METHOD_DELETE
            , url   : qaServiceUrl + 'question/admin/' + id
        });
    }

    qaServiceApi.addAnswer = function(data) {
        return $http({
            method  : Constants.METHOD_POST
            , data  : data
            , url   : qaServiceUrl + 'question/answer/admin'
        });
    }

    qaServiceApi.answerList = function(id) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : qaServiceUrl + 'question/answer/admin?questionid=' + id
        });
    }

    qaServiceApi.deleteAnswer = function(id) {
        return $http({
            method  : Constants.METHOD_DELETE
            , url   : qaServiceUrl + 'question/answer/admin/' + id
        });
    }


    return qaServiceApi;
}