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

    return qaServiceApi;
}