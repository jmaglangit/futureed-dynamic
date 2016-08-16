angular.module('futureed.services')
    .factory('ManageLocalizationService', ManageLocalizationService);

ManageLocalizationService.$inject = ['$http'];

function ManageLocalizationService($http) {

    var api = {};
    var apiUrl = '/api/v1/';

    //get available languages list
    api.getLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'module-translation/languages'
        });
    }

    //download translation
    api.downloadTranslation = function(locale){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'module-translation/generate/' + locale
        });
    }

    return api;
}