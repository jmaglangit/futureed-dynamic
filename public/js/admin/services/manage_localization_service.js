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

    //google translate field
    api.googleTranslateField = function(data){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   data,
            url     :   apiUrl + 'module-translation/google-translate'
        });
    }

    //Question

    //get all languages defined by question translation
    api.getQuestionLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'question-translation/languages'
        });
    }

    //get question translatable fields
    api.getQuestionTranslatableFields = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'question-translation/attributes'
        });
    }

    // google translate question field
    api.googleQuestionTranslateField = function(data){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   data,
            url     :   apiUrl + 'question-translation/google-translate'
        });
    }

    //Question Answer

    //get all languages defined by question answer translation
    api.getQuestionAnswerLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'question-answer-translation/languages'
        });
    }

    //get question answer translatable fields
    api.getQuestionAnswerTranslatableFields = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'question-answer-translation/attributes'
        });
    }

    // google translate question answer field
    api.googleQuestionAnswerTranslateField = function(data){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   data,
            url     :   apiUrl + 'question-answer-translation/google-translate'
        });
    }

    //Answer Explanation

    //get all languages defined by answer explanation translation
    api.getAnswerExplanationLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'answer-explanation-translation/languages'
        });
    }

    //get answer explanation translatable fields
    api.getAnswerExplanationTranslatableFields = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'answer-explanation-translation/attributes'
        });
    }

    // google translate answer explanation field
    api.googleAnswerExplanationTranslateField = function(data){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   data,
            url     :   apiUrl + 'answer-explanation-translation/google-translate'
        });
    }

    //Quote

    //get all languages defined by Quote translation
    api.getQuoteLanguages = function(){
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   apiUrl + 'quote-translation/languages'
        });
    }

    //get quote translatable fields
    api.getQuoteTranslatableFields = function(){
        return $http({
            method  :   Constants.METHOD_GET,
            url     :   apiUrl + 'quote-translation/attributes'
        });
    }

    // google translate quote field
    api.googleQuoteTranslateField = function(data){
        return $http({
            method  :   Constants.METHOD_POST,
            data    :   data,
            url     :   apiUrl + 'quote-translation/google-translate'
        });
    }


    return api;
}