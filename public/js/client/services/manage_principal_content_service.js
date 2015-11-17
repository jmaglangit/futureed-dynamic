angular.module('futureed.services').factory('ManagePrincipalContentService',ManagePrincipalContentService);

function ManagePrincipalContentService($http){

    var apiUrl = '/api/v1/';
    var reportUrl = '/api/report/';
    var managePrincipalApi = {};

    //get api report
    managePrincipalApi.schoolReport = function(school_code){
        return $http({
                method : Constants.METHOD_GET
            , url : reportUrl + 'school/' + school_code
        });
    }



}