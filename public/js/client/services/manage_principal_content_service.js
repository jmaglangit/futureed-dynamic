angular.module('futureed.services')
    .factory('ManagePrincipalContentService', ManagePrincipalContentService);

ManagePrincipalContentService.$inject = ['$http'];

function ManagePrincipalContentService($http) {

    var apiUrl = '/api/v1/';
    var reportUrl = '/api/report/';
    var managePrincipalApi = {};

    //get school report
    managePrincipalApi.schoolReport = function (school_code) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code
        });
    }

    //get school teacher report
    managePrincipalApi.schoolTeacherReport = function (school_code){
        return $http({
            method  :   Constants.METHOD_GET
            ,url    :   reportUrl + 'school/' + school_code + '/teachers'
        });
    }

    return managePrincipalApi;

}