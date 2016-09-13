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

    //get all languages list defined.
    api.getAllLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'localization/languages'
        });
    }

    //initialize all database translation
    api.initializeTranslation = function(locale){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   { locale : locale},
            url     :   apiUrl + 'localization/initialize-language'

        });
    }

    //download translation
    api.downloadTranslation = function(locale){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'module-translation/generate/' + locale
        });
    }

    //get module translatable fields.
    api.getModuleTranslationFields = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'module-translation/attributes'
        });
    }

    return api;
}